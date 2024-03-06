<?php

namespace App\Http\Controllers\management;

use App\Models\Company;
use App\Models\Pic;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PICManagement extends Controller
{
    //
  public function PicManagement()
  {
    $Pics = Pic::withInActive()->get();
    $Count = $Pics->count();
    $rate = Company::withInActive()->get();

    return view('content.management.pic-management', [
      'totalCound' => $Count,
      'verified' => '',
      'notVerified' => '',
      'userDuplicates' => '',
      'company' =>$rate,
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

    $totalData = Pic::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $Pic = Pic::offset($start)
        ->where('status','=',1)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $Pic = Pic::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('contact', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('company_name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Pic::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->Where('status', '=', "1")
        ->count();
    }

    $data = [];

    if (!empty($Pic)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Pic as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $record->name;
        $nestedData['contact'] = $record->contact;
        $nestedData['email'] = $record->email;
        $nestedData['company_name'] = $record->company_name;

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
    $_company=Company::find($request->company);


    if ($recordID) {
      // update the value
      $record = Pic::updateOrCreate(
        ['id' => $recordID],
        [
          'name' => $request->name,
          'contact' => $request->contact,
          'email' => $request->email,
          'company_id' => $request->company,
          'company_name' => $_company->name,
          ]
      );

      // updated
      return response()->json('Updated');
    } else {
      // create new one if Pic is unique
      $_record = Pic::where('id', $request->id)->first();

      if (empty($_record)) {
        $record = Pic::updateOrCreate(
          ['id' => $recordID],
          [
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'company_id' => $request->company,
            'company_name' => $_company->name,
          ]
        );

        // record created
        return response()->json(['message' => "Created",'id'=>$record->id, 'name'=>$record->name.' - '.$_company->name]);
      } else {
        // record already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  public function edit($id)
  {
    $where = ['id' => $id];

    $result = Pic::where($where)->first();

    return response()->json($result);
  }
  public function destroy($id)
  {
    //$result = Pic::where('id', $id)->delete();
    $record = Pic::updateOrCreate(
      ['id' => $id],
      [ 'status' => 0
      ]
    );
  }
}
