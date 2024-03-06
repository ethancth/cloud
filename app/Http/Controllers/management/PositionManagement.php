<?php

namespace App\Http\Controllers\management;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PositionManagement extends Controller
{
  //
  public function PositionManagement()
  {
    if(!User::find(Auth::id())->hasRole('Boss')){
      return redirect()->back()->with('message', 'Warning');
    }
    $Positions = Position::all();
    $Count = $Positions->count();

    return view('content.management.position-management', [
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
    ];

    $search = [];

    $totalData = Position::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $Position = Position::offset($start)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $Position = Position::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Position::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($Position)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Position as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
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
    //dd($request);
    $recordID = $request->id;

    if ($recordID) {
      // update the value
      $record = Position::updateOrCreate(
        ['id' => $recordID],
        ['name' => $request->name,
          'guard_name' => 'web',]
      );

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if Position is unique
      $_record = Position::where('name', $request->name)->first();

      if (empty($_record)) {
        $record = Position::updateOrCreate(
          ['id' => $recordID],
          [
            'name' => $request->name,
            'guard_name' => 'web',
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

    $result = Position::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    //$result = Position::where('id', $id)->delete();
    $record = Position::updateOrCreate(
      ['id' => $id],
      [ 'status' => 0
      ]
    );
  }
}
