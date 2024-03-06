<?php

namespace App\Http\Controllers\management;

use App\Models\ItemInv;
use App\Models\CurrencyRate;
use App\Models\OpfItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class  ItemInvManagement extends Controller
{
    //
  public function ItemInvManagement()
  {
    $ItemInvs = ItemInv::all();
    $Count = $ItemInvs->count();
    $supplier = Supplier::all();

    return view('content.management.item-management', [
      'totalCound' => $Count,
      'verified' => '',
      'notVerified' => '',
      'userDuplicates' => '',
      'supplier' =>$supplier,
    ]);
  }

  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'part_number',
      4 => 'currency',
      5 => 'is_poison',
    ];

    $search = [];

    $totalData = ItemInv::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $ItemInv = ItemInv::offset($start)
        ->where('status','=',1)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $ItemInv = ItemInv::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('part_number', 'LIKE', "%{$search}%")
        ->orWhere('description', 'LIKE', "%{$search}%")
        ->orWhere('is_poision_note', 'LIKE', "%{$search}%")
        ->orWhere('currency', 'LIKE', "%{$search}%")
        ->orWhere('currency_rate', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = ItemInv::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->count();
    }

    $data = [];

    if (!empty($ItemInv)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($ItemInv as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['fake_id'] = ++$ids;
//        $nestedData['name'] = strlen($record->name) > 50 ? substr($record->name,0,50)."..." : $record->name;
        $nestedData['name'] = $record->name;
        $nestedData['supplier_name'] = $record->supplier_name;
        $nestedData['part_number'] = $record->part_number;
        $nestedData['currency'] = $record->currency;
        $nestedData['currency_rate'] = $record->currency_rate;
        $nestedData['is_poison'] = $record->is_poison;

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

  public static function convert_from_latin1_to_utf8_recursively($dat)
  {
    if (is_string($dat)) {
      return mb_convert_encoding($dat, 'ISO-8859-1', 'UTF-8');
    } elseif (is_array($dat)) {
      $ret = [];
      foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);
      return $ret;
    } elseif (is_object($dat)) {
      foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
      return $dat;
    } else {
      return $dat;
    }
  }

  public function store(Request $request)
  {
    $set_poison=0;
    if($request->set_poison=='on')
    {
      // dd('no','1');
      $set_poison=1;
    }
    $recordID = $request->id;
    $_supplier= Supplier::find($request->supplier);

    $_custom_slug = Str::slug($request->name.'-'.$_supplier->name.'-'.$request->part_number.'-'.$request->currency);


    if ($recordID) {
      if($set_poison){
        $this->update_poison($recordID);
      }

      // update the value
      $record = ItemInv::updateOrCreate(
        ['id' => $recordID],
        ['name' => $request->name,
         'part_number' => $request->part_number,
         'supplier_id' => $request->supplier,
         'supplier_name' => $_supplier->name,
         'slug' => $_custom_slug,
           'currency' => $request->currency,
           'currency_rate' => $request->currency_rate,
           'is_poison' => $set_poison,
           'base_rate' => $request->base_rate,
           'price' => ($request->base_rate* $request->currency_rate),
          ]
      );

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if ItemInv is unique
      $_record = ItemInv::where('part_number', $request->part_number)->first();

      if (empty($_record)) {
        $record = ItemInv::updateOrCreate(
          ['id' => $recordID],
          ['name' => $request->name,
            'part_number' => $request->part_number,
            'supplier_id' => $request->supplier,
            'supplier_name' => $_supplier->name,
            'slug' => $_custom_slug,
            'currency' => $request->currency,
            'is_poison' => $set_poison,
            'currency_rate' => $request->currency_rate,
            'base_rate' => $request->base_rate,
            'price' => ($request->base_rate* $request->currency_rate),
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

  public function update_poison($item_id)
  {
    $_all_record=OpfItem::where('part_id','=',$item_id)->get();
    foreach($_all_record as $record)
    {
      $record->is_poison=1;
      $record->save();

    }

  }

  public function edit($id)
  {
    $where = ['id' => $id];

    $result = ItemInv::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    //$result = ItemInv::where('id', $id)->delete();
    $record = ItemInv::updateOrCreate(
      ['id' => $id],
      [ 'status' => 0
      ]
    );
  }
}
