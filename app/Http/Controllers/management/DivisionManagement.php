<?php

namespace App\Http\Controllers\management;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DivisionManagement extends Controller
{
    //
  public function DivisionManagement()
  {
    if(!User::find(Auth::id())->hasRole('Boss')){
      return redirect()->back()->with('message', 'Warning');
    }
    $divisions = Division::all();
    $Count = $divisions->count();

    return view('content.management.division-management', [
      'totalCound' => $Count,
      'verified' => '',
      'notVerified' => '',
      'userDuplicates' => '',
    ]);
  }

  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'status',
      4 => 'total'
    ];

    $search = [];

    $totalData = Division::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $division = Division::offset($start)
        ->where('status','=',1)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $division = Division::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Division::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->count();
    }

    $data = [];

    if (!empty($division)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($division as $user) {
        $_count=User::where('division_id','=',$user->id)->where('status','=',1)->count();
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
        $nestedData['count'] = $_count;
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

  public function store(Request $request)
  {
    $recordID = $request->id;

    if ($recordID) {
      // update the value
      $record = Division::updateOrCreate(
        ['id' => $recordID],
        ['name' => $request->name]
      );

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if division is unique
      $_record = Division::where('name', $request->name)->first();

      if (empty($_record)) {
        $record = Division::updateOrCreate(
          ['id' => $recordID],
          [ 'name' => $request->name
          ]
        );

        // record created
        return response()->json('Created');
      } else {
        // record already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  public function edit($id)
  {
    $where = ['id' => $id];

    $result = Division::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    //$result = Division::where('id', $id)->delete();
    $record = Division::updateOrCreate(
      ['id' => $id],
      [ 'status' => 0
      ]
    );
  }
}
