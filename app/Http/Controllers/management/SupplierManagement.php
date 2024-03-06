<?php

namespace App\Http\Controllers\management;

use App\Models\Supplier;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierManagement extends Controller
{
    //
  public function SupplierManagement()
  {
    $Suppliers = Supplier::all();
    $Count = $Suppliers->count();
    $rate = CurrencyRate::all();

    return view('content.management.supplier-management', [
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

    $totalData = Supplier::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $Supplier = Supplier::offset($start)
        ->where('status','=',1)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $Supplier = Supplier::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('currency', 'LIKE', "%{$search}%")
        ->orWhere('currency_rate', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Supplier::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->count();
    }

    $data = [];

    if (!empty($Supplier)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Supplier as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $record->name;
        $nestedData['currency'] = $record->currency;
        $nestedData['currency_rate'] = $record->currency_rate;

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


    if($request->currency_rate==null){
      $_currency=CurrencyRate::where('name',$request->currency)->get();
      $request->currency_rate=$_currency[0]['rate'];
    }

    if ($recordID) {
      // update the value
      $record = Supplier::updateOrCreate(
        ['id' => $recordID],
        ['name' => $request->name,
           'currency' => $request->currency,
           'currency_rate' => $request->currency_rate,
          ]
      );

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if Supplier is unique
      $_record = Supplier::where('name', $request->name)->first();

      if (empty($_record)) {
        $record = Supplier::updateOrCreate(
          ['id' => $recordID],
          [ 'name' => $request->name,
           'currency' => $request->currency,
            'currency_rate' => $request->currency_rate,
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

    $result = Supplier::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    //$result = Supplier::where('id', $id)->delete();
    $record = Supplier::updateOrCreate(
      ['id' => $id],
      [ 'status' => 0
      ]
    );
  }
}
