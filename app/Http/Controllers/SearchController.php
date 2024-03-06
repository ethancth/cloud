<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\CurrencyRate;
use App\Models\ItemInv;
use App\Models\Pic;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //


  public function getCompany(Request $request)
  {

    return Company::where('id','=',$request->value)->firstOrFail();

  }

  public function getCompanyAjax(Request $request)
  {

    $result = Company::where('name','like','%'.$request->term.'%')->where('status','=','1')->get();

    $data = [];

    if (!empty($result)) {

      foreach ($result as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['text'] = $record->name;

        $data[] = $nestedData;
      }
    }

    return $data;

  }

  public function getOpfItem(Request $request)
  {
    $_opf= \App\Models\Opf::find($request->id);
    return $_opf->item;
  }

  public function getCurrencyRate(Request $request)
  {
    //dd($request->value);

    return CurrencyRate::where('name','=',$request->value)->firstOrFail();

  }

  public function getAddressBookInfo(Request $request)
  {
    return CompanyAddress::where('id','=',$request->value)->firstOrFail();

  }

  public function getSupplierItem(Request $request)
  {
    $result = ItemInv::where('supplier_id','=',$request->value)->where('status','=',1)->get(['id','name','part_number']);

    $data = [];

    if (!empty($result)) {

      foreach ($result as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['text'] = $record->part_number;

        $data[] = $nestedData;
      }
    }

    return $data ;
  }


  public function getCustomerAddressBook(Request $request)
  {
    $result = CompanyAddress::where('company_id','=',$request->value)->where('status','=',1)->get(['id','description']);

    $data = [];

    if (!empty($result)) {

      foreach ($result as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['text'] = $record->description;

        $data[] = $nestedData;
      }
    }

    return $data ;
  }

  public function getSupplierInfo(Request $request)
  {
    //dd($request->value);

    return Supplier::where('id','=',$request->value)->firstOrFail();

  }
  public function getPic(Request $request)
  {
    //dd($request->value);

    return Pic::where('id','=',$request->value)->firstOrFail();

  }

  public function getItemInv(Request $request)
  {
    return ItemInv::where('id','=',$request->value)->firstOrFail();
  }

  public function getSalesPerson(Request $request)
  {
    //dd($request->value);

    return User::where('id','=',$request->value)->where('status','=',1)->get(['name','email','division_name']);

  }
}
