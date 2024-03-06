<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\CurrencyRate;
use App\Models\ItemInv;
use App\Models\Opf;
use App\Models\OpfItem;
use App\Models\OpfUpload;
use App\Models\Pic;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;


class OpfController extends Controller
{
    //

  public function __construct()
  {
    $this->middleware('auth', ['except' => ['view_opf_pdf']]);
  }


  public function view_opf_pdf(Request $request)
  {
    $opf=Opf::with('item')->where('id','=',$request->id)->first();

    return View('content.opf.pdf2', ['opf'=>$opf]);
  }

  public function downloadpdf(Request $request)
  {
    $title=str_pad($request->id, 6, '0', STR_PAD_LEFT) ;
    $opf=Opf::with('item')->where('id','=',$request->id)->first();

    return PDF::loadView('content.opf.pdf2', ['opf'=>$opf])->inline('OPF-' .$title. '.pdf');

  }


  public function download_opf_pdf(Request $request)
  {
    $opf=Opf::with('item')->where('id','=',$request->id)->first();
    $data = [
      [
        'quantity' => 1,
        'description' => '1 Year Subscription',
        'price' => '129.00'
      ]
    ];

    //  return View('content.opf.pdf', ['data' => $data,'opf'=>$opf]);
    $pdf = Pdf::loadView('content.opf.pdf2', ['data' => $data,'opf'=>$opf])->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->download();
    //return $pdf->stream();
    // return $pdf = Pdf::view('content.opf.pdf', ['data' => $data])->save(storage_path('app/public/opf/uploads/'.$request->opfid));

    //return View('content.opf.pdf_backup2', ['data' => $data,'opf'=>$opf]);
    $pdf = PDF::loadView('content.opf.pdf2', ['opf'=>$opf]);
    $pdf->setPaper('A3', );
    $pdf->getDomPdf()->getOptions()->set('enable_php', true);
    return response()->streamDownload(fn () => print($pdf->output()), 'Employess.pdf');
    return $pdf->download('OPF_'.$opf->id.'.pdf');
    //return $pdf->stream();
    // return $pdf = Pdf::view('content.opf.pdf', ['data' => $data])->save(storage_path('app/public/opf/uploads/'.$request->opfid));
  }

  public function demopdf(){

    $data = [
      [
        'quantity' => 1,
        'description' => '1 Year Subscription',
        'price' => '129.00'
      ]
    ];

   // return $pdf = Pdf::loadView('content.opf.pdf', ['data' => $data]);

     $pdf->download();

  }
  public function list()
  {

      $allrecord = Opf::where('status','=',1)->where('id','!=',0)->get();
      $all_open_record = Opf::where('status','=',1)->where('id','!=',0)->where('gr_status','=','open')->count();
      $Count = $allrecord->count();
     // dd($allrecord);
      $sum =Opf:: where('status', '1')->sum('gross_profit');
      $totalPO =Opf:: where('status', '1')->sum('total_po');
      $distinct_customer =DB::table('opfs')->distinct()->count('customer_id');


      return view('content.opf.list', [
        'totalCount' => $Count,
        'totalProfit' => $sum,
        'totalPO' => $totalPO,
        'totalOpenOpf' => $all_open_record,
        'distinct_customer' => $distinct_customer,
        'verified' => '',
        'notVerified' => '',
        'userDuplicates' => '',
      ]);

  }

  public function submit_opf(Request $request)
  {
    $_define_draft='draft';
    $_define_submited='submitted';
    $opf=Opf::find($request)->firstorfail();
//    if($opf->created_by==Auth::id() && $opf->opf_status==$_define_draft){
    if( $opf->opf_status==$_define_draft){

      $opf->opf_status=$_define_submited;
      $opf->submitted_by=Auth::id();
      $opf->submited_at=now();
      $opf->save();
      //TODO
     // dd($opf);

    }


  }

  public function createform()
  {

    if(Auth::user()->hasRole('Admin')){

      //Admin Role
        return redirect()->route('app-opf-list')->with('success', 'Success！');
    }

    $allCustomer=Company::where('status','=',1)->get();
    $allPic=Pic::where('status','=',1)->get();
    $allSalesPerson=User::where('status','=',1)->get();
    $allCurrency = CurrencyRate::all();
    $all_item=ItemInv::where('status','=',1)->get();
    $all_sup=Supplier::where('status','=',1)->get();
    $opf= Opf::find(0);
    $opf_upload=OpfUpload::where('opf_id','=',$opf->id)->where('status','=','1')->get();
    return view('content.opf.create', [
      'opf'=>$opf,
      'customers' => $allCustomer,
      'pic' => $allPic,
      'allSalesPerson' => $allSalesPerson,
      'cRates' => $allCurrency,
      'company' => $allCustomer,
      'iteminv' => $all_item,
      'all_sup' => $all_sup,
      'opf_file' => $opf_upload,
    ]);

  }



  public function view(Request $request, Opf $opf)
  {

    if($opf->id=='0'){
      return redirect()->route('app-opf-list')->with('success', 'Success！');
    }


    if(Auth::user()->hasRole('Boss')){
      //Boss Role
    }

    if(Auth::user()->hasRole('Admin')){

      //Admin Role
      if($opf->opf_status==='draft'){
        return redirect()->route('app-opf-list')->with('success', 'Success！');
      }
    }

    if(Auth::user()->hasRole('User')){

      if( $opf->created_by!=Auth::id()){
        return redirect()->route('app-opf-list')->with('success', 'Success！');
      }

    }





    $allCustomer=Company::where('status','=',1)->get();
    $allPic=Pic::where('status','=',1)->get();
    $allSalesPerson=User::where('status','=',1)->get();
    $allCurrency = CurrencyRate::all();
    $all_item=ItemInv::where('status','=',1)->get();
    $all_sup=Supplier::where('status','=',1)->get();
    $opf_upload=OpfUpload::where('opf_id','=',$opf->id)->where('status','=','1')->get();



    return view('content.opf.create', [
      'opf'=>$opf,
      'customers' => $allCustomer,
      'pic' => $allPic,
      'allSalesPerson' => $allSalesPerson,
      'cRates' => $allCurrency,
      'company' => $allCustomer,
      'iteminv' => $all_item,
      'all_sup' => $all_sup,
      'opf_file' => $opf_upload,
    ]);
  }


  public function checkaddressbook($request,$opfID)
  {
   $new= CompanyAddress::where('delivery_address', '=', $request->formAddress)->where('billing_address', '=', $request->formbillingaddress)->where('company_id','=',$request->formCustomer)->first();
   if(empty($new)){

     $record = CompanyAddress::updateOrCreate(
       ['id' => 0],
       [
         'company_id' => $request->formCustomer,
         'description' => 'Auto Save - OPF#'.$opfID.'   '.date("Y-m-d") ,
         'billing_address' => $request->formbillingaddress,
         'is_default' => '0',
         'delivery_address' => $request->formAddress

       ]
     );
   }

  }

  public function file_upload(Request $request)
  {

    $request->validate([
      'file' => 'required|mimes:pdf,jpg,png|max:15360',
    ]);

    if($request->opfid==0){
      return "";
    }


    $path = storage_path('app/public/opf/uploads/'.$request->opfid);

    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    }

    $file = $request->file('file');
    $_filesize=$file->getSize();
    $up_name="opf_".$request->opfid.'_'.date("d-m-Y_h_i_s_a");
   // $name = uniqid() . '_' . trim($file->getClientOriginalName()).;
    $name = $up_name . '_' . trim($file->getClientOriginalName());

    $file->move($path, $name);

    $record = OpfUpload::updateOrCreate(
      ['id' => 0],
      [
        'file_name' => $file->getClientOriginalName(),
        'download_url' => $name,
        'upload_by' => Auth::User()->name,
        'opf_id' => $request->opfid,
        'file_size' => $_filesize

      ]
    );

    return response()->json([
      'original_name' => $file->getClientOriginalName(),
    ]);
  }

  public function file_delete(Request $request)
  {

    $filename = $request->get('id');
   // ImageUpload::where('filename', $filename)->delete();
    $path = storage_path() . '/app/public/opf/uploads/' . $request->opfid.'/'.$request->id;
    if (file_exists($path)) {
      unlink($path);
      $opf_file=OpfUpload::where('download_url','=',$request->id)->first();
      $opf_file->status=0;
      $opf_file->save();
      return true;
    }else{
      return false;
    }


  }

  public function index(Request $request)
  {
  //  dd($request);




    $columns = [
      1 => 'created_at',
      2 => 'id',
      3 => 'customer_name',
      4 => 'total_po',
      5 => 'opf_status',
      6 => 'opf_status',
      7 => 'current_division',
      8 => 'progress',
    ];

    $search = [];

    $totalData = Opf::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');




    if (empty($request->input('search.value'))) {

      $search = $request->input('search.value');

      if(Auth::user()->hasRole('Boss')){
        //Boss Role
        $Opf = Opf::offset($start)
          ->where('status','=',1)
          ->where('id','!=',0)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      }

      if(Auth::user()->hasRole('Admin')){

        //Admin Role
        $Opf=Opf::offset($start)
          ->where('status','=',1)
          ->where('opf_status','!=','draft')
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

      }

      if(Auth::user()->hasRole('User')){

        $Opf=Opf::offset($start)
          ->where('status','=',1)
          ->where('created_by','=',Auth()->id())
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();


      }

    } else {
      $search = $request->input('search.value');

      if(Auth::user()->hasRole('Boss')){
        //Boss Role

        $Opf=Opf::where('status','=',1)
          ->where(function($query)use ($search)
          {
            $query
              ->orWhere('customer_delivery_address', 'LIKE', "%{$search}%")
              ->orWhere('customer_billing_address', 'LIKE', "%{$search}%")
              ->orWhere('pic_name', 'LIKE', "%{$search}%")
              ->orWhere('pic_email', 'LIKE', "%{$search}%")
              ->orWhere('total_po', 'LIKE', "%{$search}%")
              ->orWhere('total_cost_of_goods', 'LIKE', "%{$search}%")
              ->orWhere('total_tax', 'LIKE', "%{$search}%")
              ->orWhere('total_shipping', 'LIKE', "%{$search}%")
              ->orWhere('gross_profit', 'LIKE', "%{$search}%")
              ->orWhere('gross_profit_percent', 'LIKE', "%{$search}%")
              ->orWhere('opf_status', 'LIKE', "%{$search}%")
              ->orWhere('notes', 'LIKE', "%{$search}%")
              ->orWhere('tags', 'LIKE', "%{$search}%")
              ->orWhere('current_division', 'LIKE', "%{$search}%")
              ->orWhere('slug', 'LIKE', "%{$search}%")
              ->orWhere('due_date', 'LIKE', "%{$search}%")
              ->orWhere('currency', 'LIKE', "%{$search}%")
              ->orWhere('currency_rate', 'LIKE', "%{$search}%")
              ->orWhere('po_value', 'LIKE', "%{$search}%");
          })

          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered=Opf::where('id', 'LIKE', "%{$search}%")
//        ->orWhere('name', 'LIKE', "%{$search}%")
          ->Where('status', '=', "1")
          ->count();
      }

      if(Auth::user()->hasRole('Admin')){

        //Admin Role

        $Opf=Opf::where('status','=',1)
          ->where('opf_status','!=','draft')
          ->where(function($query)use ($search)
          {
            $query
              ->orWhere('customer_delivery_address', 'LIKE', "%{$search}%")
              ->orWhere('customer_billing_address', 'LIKE', "%{$search}%")
              ->orWhere('pic_name', 'LIKE', "%{$search}%")
              ->orWhere('pic_email', 'LIKE', "%{$search}%")
              ->orWhere('total_po', 'LIKE', "%{$search}%")
              ->orWhere('total_cost_of_goods', 'LIKE', "%{$search}%")
              ->orWhere('total_tax', 'LIKE', "%{$search}%")
              ->orWhere('total_shipping', 'LIKE', "%{$search}%")
              ->orWhere('gross_profit', 'LIKE', "%{$search}%")
              ->orWhere('gross_profit_percent', 'LIKE', "%{$search}%")
              ->orWhere('opf_status', 'LIKE', "%{$search}%")
              ->orWhere('notes', 'LIKE', "%{$search}%")
              ->orWhere('tags', 'LIKE', "%{$search}%")
              ->orWhere('current_division', 'LIKE', "%{$search}%")
              ->orWhere('slug', 'LIKE', "%{$search}%")
              ->orWhere('due_date', 'LIKE', "%{$search}%")
              ->orWhere('currency', 'LIKE', "%{$search}%")
              ->orWhere('currency_rate', 'LIKE', "%{$search}%")
              ->orWhere('po_value', 'LIKE', "%{$search}%");
          })

          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered=Opf::where('id', 'LIKE', "%{$search}%")
          ->Where('status', '=', "1")
          ->where('opf_status','!=','draft')
          ->count();
      }


      if(Auth::user()->hasRole('User')){

        $Opf=Opf::where('status','=',1)
          ->where('created_by','=',Auth()->id())
          ->where(function($query)use ($search)
          {
            $query
              ->orWhere('customer_delivery_address', 'LIKE', "%{$search}%")
              ->orWhere('customer_billing_address', 'LIKE', "%{$search}%")
              ->orWhere('pic_name', 'LIKE', "%{$search}%")
              ->orWhere('pic_email', 'LIKE', "%{$search}%")
              ->orWhere('total_po', 'LIKE', "%{$search}%")
              ->orWhere('total_cost_of_goods', 'LIKE', "%{$search}%")
              ->orWhere('total_tax', 'LIKE', "%{$search}%")
              ->orWhere('total_shipping', 'LIKE', "%{$search}%")
              ->orWhere('gross_profit', 'LIKE', "%{$search}%")
              ->orWhere('gross_profit_percent', 'LIKE', "%{$search}%")
              ->orWhere('opf_status', 'LIKE', "%{$search}%")
              ->orWhere('notes', 'LIKE', "%{$search}%")
              ->orWhere('tags', 'LIKE', "%{$search}%")
              ->orWhere('current_division', 'LIKE', "%{$search}%")
              ->orWhere('slug', 'LIKE', "%{$search}%")
              ->orWhere('due_date', 'LIKE', "%{$search}%")
              ->orWhere('currency', 'LIKE', "%{$search}%")
              ->orWhere('currency_rate', 'LIKE', "%{$search}%")
              ->orWhere('po_value', 'LIKE', "%{$search}%");
          })

          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered=Opf::where('id', 'LIKE', "%{$search}%")
//        ->orWhere('name', 'LIKE', "%{$search}%")
          ->Where('status', '=', "1")
          ->where('created_by','=',Auth()->id())
          ->count();

      }


    }

    $data = [];

    if (!empty($Opf)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Opf as $record) {
        $nestedData['id'] = $record->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['customer_name'] = $record->customer_name;
//        $nestedData['name'] = $record->id;
        $nestedData['po_value'] = $record->po_value;
        $nestedData['currency'] = $record->currency;
        $nestedData['currency_rate'] = $record->currency_rate;
        $nestedData['sales_person'] = $record->sales_person;
        $nestedData['sales_person_id'] = $record->sales_person_id;
        $nestedData['current_division'] = $record->current_division;
        $nestedData['gr_status'] = $record->gr_status;
        $nestedData['due_date'] = $record->due_date;
        $nestedData['pic_name'] = $record->pic_name;
        $nestedData['pic_email'] = $record->pic_email;
        $nestedData['pic_contact'] = $record->contact;
        $nestedData['tags'] = $record->tags;
        $nestedData['total_po'] = $record->total_po;
        $nestedData['total_cost_of_goods'] = $record->total_cost_of_goods;
        $nestedData['total_tax'] = $record->total_tax;
        $nestedData['total_shipping'] = $record->total_shipping;
        $nestedData['gross_profit'] = $record->gross_profit;
        $nestedData['gross_profit_percent'] = $record->gross_profit_percent;
        $nestedData['opf_status'] = ucfirst($record->opf_status);
        $nestedData['grn_status'] = $record->grn_status;
        $nestedData['total_po_check'] = $record->item->sum('po_check');
        $nestedData['total_stock_check'] = $record->item->sum('stock_check');
        $nestedData['total_gr_check'] = $record->item->sum('gr_check');
        $nestedData['total_invoice_check'] = $record->item->sum('invoice_check');
        $nestedData['total_do_check'] = $record->item->sum('do_check');
        $nestedData['total_opf_item'] = $record->item->count();
        $_progress_base=($record->item->count()*5);
        if($_progress_base==0){
          $_progress_base=1;
        }
        $_all_check=$record->item->sum('po_check')+$record->item->sum('stock_check')+$record->item->sum('gr_check')+$record->item->sum('invoice_check')+$record->item->sum('do_check');
        $_progress=($_all_check/$_progress_base)*100;
        $nestedData['progress'] = number_format($_progress, 2, '.', '');


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

    if($request->formTagging){
      $_tagging=implode(', ', array_column(json_decode($request->formTagging), 'value'));
    }else{
      $_tagging=null;
    }

    $_customer=Company::find($request->formCustomer);
    $_pic=Pic::find($request->formPIC);
    $recordID = $request->opf_id;
    $_sales_info=User::find($request->formSalesPersonid);

    if(!$request->formCurrencyRate){
      $_getCurrency=CurrencyRate::where('name',$request->formCurrency)->first();
      $_rate= $_getCurrency->rate;
    }else{
      $_rate=$request->formCurrencyRate;
    }
    $this->checkaddressbook($request,$recordID);
    if ($recordID) {
      // update the value
      $record = Opf::updateOrCreate(
        ['id' => $recordID],
        [
          'customer_id' => $_customer->id,
          'customer_name' => $_customer->name,
          'customer_address' => $request->formAddress,
          'customer_delivery_address' => $request->formAddress,
          'customer_billing_address' => $request->formbillingaddress,
          'currency' => $request->formCurrency,
          'currency_rate' => $_rate,
          'gr_status' => $request->formStatus,
          'pic_id' => $_pic->id,
          'pic_name' => $_pic->name,
          'contact' => $request->picContact,
          'pic_email' => $request->picEmail,
          'sales_person_id' => $request->formSalesPersonid,
          'sales_person' => $_sales_info->name,
          'current_division' => $request->formDivision,
          'po_value' => $request->formPoNumber,
          'due_date' => $request->formDueDate,
          'notes' => $request->formNotes,
          'tags' => $_tagging,
          'gross_profit_percent' =>  $request->field_sum_total_gross_profit_percent ?? 0,
          'gross_profit' =>  $request->field_sum_total_gross_profit ?? 0,
          'total_shipping' =>  $request->field_sum_total_shipping ?? 0,
          'total_tax' =>  $request->field_sum_total_tax ?? 0,
          'total_cost_of_goods' =>  $request->field_sum_total_cost_of_goods ?? 0,
          'total_po' =>  $request->field_sum_total_po_value ?? 0,
        ]
      );


      $_opf_check_gr=1;
//      dd(!empty($request->opfitem));
      $_search_slug='';
      if(!empty($request->opfitem)) {


        OpfItem::where('opf_id', '=', $recordID)->delete();
        $_search_slug='';
        foreach ($request->opfitem as $value) {




          $_form_po_check = false;
          $_form_gr_check = false;
          $_formItemStock = false;
          $_form_invoice_check = false;
          $_form_delivery_check = false;
          $_is_poison = false;
          $_check_gr = 0;
          $_check_gr_status = 0;

          if (isset($value['form_po_check'])) {
            // dd('got');
            $_form_po_check = true;
            $_check_gr++;
          }
          if (isset($value['formItemStock'])) {
            // dd('got');
            $_formItemStock = true;
            $_check_gr++;
          }
          if (isset($value['form_gr_check'])) {
            // dd('got');
            $_form_gr_check = true;
            $_check_gr++;
          }
          if (isset($value['form_invoice_check'])) {
            // dd('got');
            $_form_invoice_check = true;
            $_check_gr++;
          }
          if (isset($value['form_delivery_check'])) {
            // dd('got');
            $_form_delivery_check = true;
            $_check_gr++;
          }
          if (isset($value['part_item_poison'])) {
            // dd('got');
            $_is_poison = true;
          }

          if ($_check_gr == '5') {
            $_check_gr_status = 1;
            $_opf_check_gr = 1;
          } else {
            $_opf_check_gr = 0;
          }


          $_supplier_info = Supplier::find($value['form_supplier'] ?? 0);


          if ($_supplier_info && isset($value['form_part_number'])) {
            $iteminv=ItemInv::find($value['form_part_number']);


            $_search_slug.=$_supplier_info->name.'__'.$value['form_part_number'].'__'.$iteminv['part_number'].'__'.$value['form_part_desc'].'__'.$value['form_po_no'].
              '__'.$value['form_gr_no'].
              '__'.$value['form_po_no'].
              '__'.$value['form_invoice_no'].
              '__'.$value['form_delivery_no'].
              '__'.$value['part_item_note'].
              '__'.$value['formInputcurrency'];


            $opf_item= OpfItem::create(
              [
                'opf_id' => $recordID,
                'supplier_id' => $value['form_supplier'],
                'supplier_name' => $_supplier_info->name,
                'part_id' => $value['form_part_number'],
                'part_description' => $iteminv['part_number'],
                'part_name' => $value['form_part_desc'],
                'unit_cost' => $value['form_unit_cost'],
                'qty' => $value['form_qty'],
                'freight' => $value['form_freight'],
                'unit_selling_price' => $value['form_unit_selling_price'],
                'taxes' => $value['form_taxes'],
                'total_selling_price' => $value['form_part_total_selling_price'],
                'total_cost' => $value['form_total_cost'],
                'freight_cost' => $value['form_freight_cost'],
                'taxes_cost' => $value['form_taxduty_cost'],
                'unit_landed_cost' => $value['form_unit_landed_cost'],
                'profit' => $value['form_unit_item_profit'],
                'stock_check' => $_formItemStock,
                'po_check' => $_form_po_check,
                'po_number' => $value['form_po_no'],
                'gr_check' => $_form_gr_check,
                'gr_number' => $value['form_gr_no'],
                'invoice_check' => $_form_invoice_check,
                'invoice_number' => $value['form_invoice_no'],
                'do_check' => $_form_delivery_check,
                'do_number' => $value['form_delivery_no'],
                'is_poison' => $_is_poison,
                'margin' => $value['form_item_margin'],
                'currency' => $value['formInputcurrency'],
                'total_gr_check' => $_check_gr_status,
                'part_comment' => $value['part_item_note']

              ]);
          }
          //dd($_supplier_info->name);


        }

      }else{
        OpfItem::where('opf_id', '=', $recordID)->delete();
      }
      $update_opf_gr=Opf::find($record->id);
      $update_opf_gr->grn_status=$_opf_check_gr;
      $update_opf_gr->slug=$_search_slug;
      $update_opf_gr->save();
      // user updated
      //return redirect()->route('user-management')->with('success', 'Success！');
      return response()->json(['message' => "Updated",'id'=>$record->id]);
    } else {
      // create new one if ItemInv is unique
      $_record = Opf::where('id', $request->id)->first();

      if (empty($_record)) {


        $record = Opf::updateOrCreate(
          ['id' => $recordID],
          [
            'customer_id' => $_customer->id,
            'customer_name' => $_customer->name,
            'customer_billing_address' => $request->formbillingaddress,
            'customer_delivery_address' => $request->formAddress,
            'currency' => $request->formCurrency,
            'currency_rate' => $request->formCurrencyRate,
            'gr_status' => $request->formStatus,
            'pic_id' => $_pic->id,
            'pic_name' => $_pic->name,
            'contact' => $request->picContact,
            'pic_email' => $request->picEmail,
            'sales_person_id' => $request->formSalesPersonid,
            'sales_person' => $_sales_info->name,
            'current_division' => $request->formDivision,
            'po_value' => $request->formPoNumber,
            'due_date' => $request->formDueDate,
            'notes' => $request->formNotes,
            'tags' => $_tagging,
            'gross_profit_percent' =>  $request->field_sum_total_gross_profit_percent ?? 0,
            'gross_profit' =>  $request->field_sum_total_gross_profit ?? 0,
            'total_shipping' =>  $request->field_sum_total_shipping ?? 0,
            'total_tax' =>  $request->field_sum_total_tax ?? 0,
            'total_cost_of_goods' =>  $request->field_sum_total_cost_of_goods ?? 0,
            'total_po' =>  $request->field_sum_total_po_value ?? 0,
            'created_by' => Auth()->id(),
          ]
        );

        if(!empty($request->opfitem)) {

          $_search_slug='';


          foreach ($request->opfitem as $value) {


            $_form_po_check = false;
            $_form_gr_check = false;
            $_formItemStock = false;
            $_form_invoice_check = false;
            $_form_delivery_check = false;
            $_is_poison = false;
            $_check_gr = 0;
            $_check_gr_status = 0;

            if (isset($value['form_po_check'])) {
              // dd('got');
              $_form_po_check = true;
              $_check_gr++;
            }
            if (isset($value['formItemStock'])) {
              // dd('got');
              $_formItemStock = true;
              $_check_gr++;
            }
            if (isset($value['form_gr_check'])) {
              // dd('got');
              $_form_gr_check = true;
              $_check_gr++;
            }
            if (isset($value['part_item_poison'])) {
              // dd('got');
              $_is_poison = true;
            }

            if (isset($value['form_invoice_check'])) {
              // dd('got');
              $_form_invoice_check = true;
              $_check_gr++;
            }
            if (isset($value['form_delivery_check'])) {
              // dd('got');
              $_form_delivery_check = true;
              $_check_gr++;
            }

            if ($_check_gr == '5') {
              $_check_gr_status = 1;
            }


            $_supplier_info = Supplier::find($value['form_supplier']);
            //dd($_supplier_info->name);
            $iteminv=ItemInv::find($value['form_part_number']);
            $opf_item=OpfItem::create(
              [
                'opf_id' => $record->id,
                'supplier_id' => $value['form_supplier'],
                'supplier_name' => $_supplier_info->name,
                'part_id' => $value['form_part_number'],
                'part_description' => $iteminv['part_number'],
                'part_name' => $value['form_part_desc'],
                'unit_cost' => $value['form_unit_cost'],
                'qty' => $value['form_qty'],
                'freight' => $value['form_freight'],
                'unit_selling_price' => $value['form_unit_selling_price'],
                'taxes' => $value['form_taxes'],
                'total_selling_price' => $value['form_part_total_selling_price'],
                'total_cost' => $value['form_total_cost'],
                'freight_cost' => $value['form_freight_cost'],
                'taxes_cost' => $value['form_taxduty_cost'],
                'unit_landed_cost' => $value['form_unit_landed_cost'],
                'profit' => $value['form_unit_item_profit'],
                'stock_check' => $_formItemStock,
                'po_check' => $_form_po_check,
                'po_number' => $value['form_po_no'],
                'gr_check' => $_form_gr_check,
                'gr_number' => $value['form_gr_no'],
                'is_poison' => $_is_poison,
                'margin' => $value['form_item_margin'],
                'currency' => $value['formInputcurrency'],
                'total_gr_check' => $_check_gr_status,
                'part_comment' => $value['part_item_note'],
                'invoice_check' => $_form_invoice_check,
                'invoice_number' => $value['form_invoice_no'],
                'do_check' => $_form_delivery_check,
                'do_number' => $value['form_delivery_no'],


              ]);


            $_search_slug.=$_supplier_info->name.'__'.$value['form_part_number'].'__'.$iteminv['part_number'].'__'.$value['form_part_desc'].'__'.$value['form_po_no'].
              '__'.$value['form_gr_no'].
              '__'.$value['form_po_no'].
              '__'.$value['form_invoice_no'].
              '__'.$value['form_delivery_no'].
              '__'.$value['part_item_note'].
              '__'.$value['formInputcurrency'];

          }

        }else{
          $_search_slug='';
        }

        $update_opf_gr=Opf::find($record->id);
        $update_opf_gr->slug=$_search_slug;
        $update_opf_gr->save();
        // record created
        //return to_route('app-opf-view-form', ['opf' => $record->id]);
       return response()->json(['message' => "Created",'id'=>$record->id,'set_redirect'=>true]);
      } else {
        // record already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }



}
