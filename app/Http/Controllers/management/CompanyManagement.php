<?php

namespace App\Http\Controllers\management;

use App\Models\Company;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyManagement extends Controller
{
    //
  public function CompanyManagement()
  {
    $Companys = Company::all();
    $Count = $Companys->count();
    $rate = CurrencyRate::all();

    return view('content.management.company-management', [
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
      3 => 'address_1',
      4 => 'currency',
    ];

    $search = [];

    $totalData = Company::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $Company = Company::offset($start)
        ->where('status','=',1)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $Company = Company::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('address_1', 'LIKE', "%{$search}%")
        ->orWhere('currency', 'LIKE', "%{$search}%")
        ->orWhere('currency_rate', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Company::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->count();
    }

    $data = [];

    if (!empty($Company)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Company as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $record->name;
        $nestedData['address_1'] = $record->address_1;
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
      $_currency=CurrencyRate::where('name','=',$request->currency)->first();

      $request->currency_rate=$_currency->rate;
    }

    if ($recordID) {
      // update the value
      $record = Company::updateOrCreate(
        ['id' => $recordID],
        ['name' => $request->name,
         'address_1' => $request->address_1,
         'billing_address' => $request->billing_address,
           'currency' => $request->currency,
           'currency_rate' => $request->currency_rate,
          ]
      );


      // user updated
      return response()->json('Updated');
    } else {
      // create new one if Company is unique
      $_record = Company::where('name', $request->name)->first();

      if (empty($_record)) {
        $record = Company::updateOrCreate(
          ['id' => $recordID],
          [ 'name' => $request->name,
           'address_1' => $request->address_1,
            'billing_address' => $request->billing_address,
           'currency' => $request->currency,
           'currency_rate' => $request->currency_rate,
          ]
        );

        // record created
        return response()->json(['message' => "Created",'id'=>$record->id, 'name'=>$record->name]);
      } else {
        // record already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  public function updateAddress(Request $request){



  }

  public function edit($id)
  {
    $where = ['id' => $id];

    $result = Company::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    //$result = Company::where('id', $id)->delete();
    $record = Company::updateOrCreate(
      ['id' => $id],
      [ 'status' => 0
      ]
    );
  }
}
