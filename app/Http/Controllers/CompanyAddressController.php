<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class CompanyAddressController extends Controller
{
    //

  public function list(Company $company)
  {
    return view('content.management.addressbook', [
      'totalCound' => '',
      'verified' => '',
      'notVerified' => '',
      'userDuplicates' => '',
      'company' =>$company
    ]);

//
  }


  public function index(Request $request,Company $company)
  {
    $columns = [
      1 => 'id',
      2 => 'description',
      3 => 'delivery_address',
      4 => 'billing_address'
    ];

    $search = [];

    //$totalData = $company->defaultaddressbook->count();
    $totalData = CompanyAddress::where('status','=',1)
      ->where('company_id','=',$company->id)
      ->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $CompanyAddress = CompanyAddress::offset($start)
        ->where('company_id','=',$company->id)
        ->where('status','=',1)
        ->limit($limit)

        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

//      $CompanyAddress = CompanyAddress::where('id', 'LIKE', "%{$search}%")
//        ->where('status','=',1)
//        ->where('company_id','=',$company->id)
//        ->orWhere('delivery_address', 'LIKE', "%{$search}%")
//        ->orWhere('description', 'LIKE', "%{$search}%")
//        ->orWhere('billing_address', 'LIKE', "%{$search}%")
//
//
//        ->offset($start)
//        ->limit($limit)
//        ->orderBy($order, $dir)
//        ->get();


      $CompanyAddress = CompanyAddress::where('status','=',1)
        ->where('company_id','=',$company->id)
        ->where(function($query)use ($search)
        {
          $query->orWhere('delivery_address', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('billing_address', 'LIKE', "%{$search}%");
        })

        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();




      $totalFiltered = CompanyAddress::where('id', 'LIKE', "%{$search}%")
        ->orWhere('delivery_address', 'LIKE', "%{$search}%")
        ->orWhere('billing_address', 'LIKE', "%{$search}%")
        ->orWhere('description', 'LIKE', "%{$search}%")
        ->where('company_id','=',$company->id)
        ->where('status','=',1)
        ->count();
    }

    $data = [];

    if (!empty($CompanyAddress)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($CompanyAddress as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['description'] = $user->description;
        $nestedData['delivery_address'] = $user->delivery_address;
        $nestedData['billing_address'] = $user->billing_address;

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

  public function store(Request $request,Company $company)
  {
    if(!$request->set_default_address=='on')
    {
     // dd('no','1');
      $_set_default=0;
    }else{
     //Set as Default Address
      $_set_default=1;

      $_updateCompany=Company::find($company->id);
      $_updateCompany->billing_address=$request->billing_address;
      $_updateCompany->address_1=$request->delivery_address;
      $_updateCompany->save();
    }

    $recordID = $request->id;

    if ($recordID) {
      // update the value
      $record = CompanyAddress::updateOrCreate(
        ['id' => $recordID],
        [
          'company_id' => $company->id,
          'description' => $request->name,
          'billing_address' => $request->billing_address,
          'is_default' => $_set_default,
          'delivery_address' => $request->delivery_address

          ]
      );

      // user updated
      return response()->json('Updated');
    } else {
      $_record = CompanyAddress::where('billing_address', $request->billing_address)->where('delivery_address', $request->delivery_address)->first();

      if (empty($_record)) {
        $record = CompanyAddress::updateOrCreate(
          ['id' => $recordID],
          [
            'company_id' => $company->id,
            'description' => $request->name,
            'billing_address' => $request->billing_address,
            'is_default' => $_set_default,
            'delivery_address' => $request->delivery_address

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

  public function edit(Company $company, CompanyAddress $id )
  {
    return response()->json($id);
  }
  public function destroy(Company $company,$id)
  {

    $result = CompanyAddress::where('id', $id)->delete();
//    $record = CompanyAddress::updateOrCreate(
//      ['id' => $id],
//      [ 'status' => 0
//      ]
//    );
  }
}
