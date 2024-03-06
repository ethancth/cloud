<?php

namespace App\Http\Controllers\management;

use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyManagement extends Controller
{
    //
  public function CurrencyManagement()
  {
    $Currencys = CurrencyRate::all();
    $Count = $Currencys->count();
    $rate = CurrencyRate::all();

    return view('content.management.currency-management', [
      'totalCound' => $Count,
      'verified' => '',
      'notVerified' => '',
      'userDuplicates' => '',
      'cRates' =>$rate,
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

    $totalData = CurrencyRate::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $Currency = CurrencyRate::offset($start)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $Currency = CurrencyRate::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('rate', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = CurrencyRate::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($Currency)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Currency as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $record->name;
        $nestedData['rate'] = $record->rate;
        $nestedData['time'] = $record->updated_at->diffForHumans();

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
      $record = CurrencyRate::updateOrCreate(
        ['id' => $recordID],
        ['name' => strtoupper($request->name),
           'rate' => $request->rate,
          ]
      );

      return response()->json('Updated');
    } else {
      // create new one if Currency is unique
      $_record = CurrencyRate::where('name', strtoupper($request->name))->first();
      if (empty($_record)) {
        $record = CurrencyRate::updateOrCreate(
          ['id' => $recordID],
          [ 'name' => $request->name,
           'rate' => $request->rate,

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

    $result = CurrencyRate::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    $result = CurrencyRate::where('id', $id)->delete();
//    $record = CurrencyRate::updateOrCreate(
//      ['id' => $id],
//      [ 'status' => 0
//      ]
//    );
  }
}
