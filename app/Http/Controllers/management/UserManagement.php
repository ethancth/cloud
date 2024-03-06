<?php

namespace App\Http\Controllers\management;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PHPUnit\Metadata\PostCondition;

class UserManagement extends Controller
{
  /**
   * Redirect to user-management view.
   *
   */

  public function __construct()
  {
//    $this->middleware(['role:Boss'],['only' => ['index']]);


  }
  public function UserManagement()
  {

    if(!User::find(Auth::id())->hasRole('Boss')){
      return redirect()->back()->with('message', 'Warning');
    }

    $users = User::where('status','=','1')->get();
    $userCount = $users->count();
    $verified = User::whereNotNull('email_verified_at')->where('status','=','1')->get()->count();
    $notVerified = User::whereNull('email_verified_at')->where('status','=','1')->get()->count();
    $usersUnique = $users->unique(['email']);
    $userDuplicates = $users->diff($usersUnique)->count();
    $division=Division::where('status', 1)->get();
    $position=Position::all();

    return view('content.management.user-management', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
      'divisions' => $division,
      'positions' => $position,
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'email',
      4 => 'email_verified_at',
    ];

    $search = [];

    $totalData = User::where('status','=','1')->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::offset($start)
        ->Where('status', '=', "1")
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('position_name', 'LIKE', "%{$search}%")
        ->orWhere('division_name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('position_name', 'LIKE', "%{$search}%")
        ->orWhere('division_name', 'LIKE', "%{$search}%")
        ->orWhere('position_name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
        $nestedData['division_name'] = $user->division_name;
        $nestedData['role'] = $user->position_name;
        $nestedData['profile_pic'] = $user->profile_photo_url;
        $nestedData['email_verified_at'] = $user->email_verified_at;

        $data[] = $nestedData;
      }
    }
    if ($data) {

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $userID = $request->id;
    $_division=Division::find($request->division);
    $_position=Position::find($request->position);

    if ($userID) {
      // update the value
      $users = User::updateOrCreate(
        ['id' => $userID],
        [
          'name' => $request->name,
          'email' => $request->email,
          'contact'=>$request->userContact,
          'position_id'=>$_position->id,
          'position_name'=>$_position->name,
          'division_id'=>$_division->id,
          'division_name'=>$_division->name,
        ]
      );
      $users->syncRoles($_position->name);

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if email is unique
      $userEmail = User::where('email', $request->email)->first();

      if (empty($userEmail)) {
        $users = User::updateOrCreate(
          ['id' => $userID],
          [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->email),
            'contact'=>$request->userContact,
            'position_id'=>$_position->id,
            'position_name'=>$_position->name,
            'division_id'=>$_division->id,
            'division_name'=>$_division->name,
          ]
        );
        $users->syncRoles($_position->name);
        // user created


        return response()->json('Created');

      } else {
        // user already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $where = ['id' => $id];

    $users = User::where($where)->first();

    return response()->json($users);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $users = User::find($id);
    $users->status='0';
    $users->save();
  }
}
