<?php

namespace App\Http\Controllers;

use App\Models\ItemInv;
use App\Models\Opf;
use App\Models\OpfItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class OpfReportController extends Controller
{

  public function livewire_report(){
    return view('content.report.live_report');
  }

  public function summary_report(Request $request){




    if (isset($request->poison_check)) {
      $_is_poison = 1;
    }else{
      $_is_poison = 0;
    }

    if (isset($request->po_check)) {
      $_is_po = 1;
    }else{
      $_is_po = 0;
    }

    if (isset($request->gr_check)) {
      $_is_gr = 1;
    }else{
      $_is_gr = 0;
    }

    if (isset($request->status_check)) {
      $_status = 'open';
      $_f_status=1;
    }else{
      $_status = 'close';
      $_f_status=0;
    }

    if ($request->input('range')) {
      $_request_date = explode(" to ", $request['range']);
      $_start_request_date=$_request_date[0];

      if(isset($_request_date[1])){
        $_end_request_date=$_request_date[1];
      }else{
        $_end_request_date=$_request_date[0];
      }
      $_start_request_date=carbon::parse($_start_request_date)->startOfDay();
      $_end_request_date=carbon::parse($_end_request_date)->endOfDay();

    }else{
      $available_day_start =Opf::selectRaw('created_at')->where('id','!=',0)->orderby('created_at','asc')->get();
      $available_day_end =Opf::selectRaw('created_at')->where('id','!=',0)->orderby('created_at','desc')->get();

//      $_start_request_date=carbon::parse($available_day_start[0]['created_at'])->startOfDay()->format('Y-m-d');;
      $_start_request_date=carbon::parse($available_day_start[0]['created_at']);;
      $_end_request_date=carbon::parse($available_day_end[0]['created_at']);

    }

   // dd($_start_request_date.' - -  '. $_end_request_date);
    //dd($_start_request_date. ' - '. $_end_request_date);
    $available_part_number =OpfItem::selectRaw('part_description as part_number')->where('opf_id','!=',0)->orderby('part_number','asc')->groupBy(DB::raw('part_number'))->get();
    $available_customer =Opf::selectRaw('customer_name as name')->where('id','!=',0)->orderby('name','asc')->groupBy(DB::raw('name'))->get();


    $available_day_start =Opf::selectRaw('created_at')->where('id','!=',0)->orderby('created_at','asc')->get();
    $available_day_end =Opf::selectRaw('created_at')->where('id','!=',0)->orderby('created_at','desc')->get();


    $opf_items = DB::table('opf_items')
      ->leftJoin('opfs', 'opfs.id', '=', 'opf_items.opf_id')
      ->select(
        'opfs.created_at as created_at',
        'opf_id',
        'customer_name',
        'sales_person',
        'current_division',
        'contact',
        'part_description',
        'part_name',
        'qty',
        'unit_cost',
        'total_cost',
        'unit_selling_price',
        'total_selling_price',
        'profit',
        'margin',
        'stock_check',
        'po_check',
        'po_number',
        'po_value',
        'gr_check',
        'is_poison',
        'gr_status'
      )
      ->when($request->has('poison_check'), function ($query) use ($_is_poison) {
        $query->where('is_poison', $_is_poison);
      })
      ->when($request->has('po_check'), function ($query) use ($_is_po) {
        $query->where('po_check', $_is_po);
      })
      ->when($request->has('gr_check'), function ($query) use ($_is_gr) {
        $query->where('gr_check','=',$_is_gr);
      })
      ->when($request->has('status_check'), function ($query) use ($_status) {
        $query->where('gr_status','=',$_status);
      })
      ->when($request->has('select_path_number'), function ($query) use ($request) {
        $query->whereIn('part_description',array_merge($request['select_path_number'] ));
      })
      ->when($request->has('select_customer'), function ($query) use ($request) {
        $query->whereIn('customer_name',array_merge($request['select_customer'] ));
      })

      ->wherebetween('opfs.created_at', [$_start_request_date, $_end_request_date])->get();

   // dd($opf_items);




    $ItemInvs = ItemInv::all();
    $Count = $ItemInvs->count();
    $supplier = Supplier::all();
    $_allitem=OpfItem::all();


    $date = new Carbon($_start_request_date);
    $edate = new Carbon($_end_request_date);
    $sdate = \Carbon\Carbon::parse($date)->format('Y-m-d');
    $edate = \Carbon\Carbon::parse($edate)->format('Y-m-d');

    $select_c=$request['select_customer'];
    $select_p=$request['select_path_number'];

    return view('content.report.report', [
      'totalCound' => $Count,

      's_date' => $sdate,
      'e_date' => $edate,


      'f_is_poison'=>$_is_poison,
      'f_is_gr'=>$_is_gr,
      'f_is_status'=>$_f_status,
      'f_is_po'=>$_is_po,
      'f_is_po'=>$_is_po,
      'f_a_c_name'=>$select_c,
      'f_a_p_number'=>$select_p,

      'verified' => '',
      'notVerified' => '',
      'userDuplicates' => '',
      'supplier' =>$supplier,
      'datas'=>$opf_items,
      'available_part_number'=>$available_part_number,
      'available_customer'=>$available_customer,
      'available_day_s'=>$available_day_start[0],'available_day_e'=>$available_day_end[0]
    ]);

  }

  public function filter_array($array,$name){

    foreach ($array as $_array)
    {
      $rc[] = $_array[$name];
    }
    return $rc;

  }
}
