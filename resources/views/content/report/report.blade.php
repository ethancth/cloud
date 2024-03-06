@extends('layouts/layoutMaster')

@section('title', 'Item Management')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
@endsection
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
@endsection

@section('page-script')
  <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>


  function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('myTable2');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
      XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
      XLSX.writeFile(wb, fn || ('OpfReport.' + (type || 'xlsx')));
  }

  $("#available_path_number").select2();
  $("#available_path_number_checkbox").click(function(){
    if($("#available_path_number_checkbox").is(':checked') ){
      $("#available_path_number > option").prop("selected","selected");
      $("#available_path_number").trigger("change");
    }else{
      $('#available_path_number').val(null).trigger('change');
    }
  });

  $("#available_customer").select2();
  $("#available_customer_checkbox").click(function(){
    if($("#available_customer_checkbox").is(':checked') ){
      $("#available_customer > option").prop("selected","selected");
      $("#available_customer").trigger("change");
    }else{
      $('#available_customer').val(null).trigger('change');

    }
  });



  // $("[name='submitButton").click();

  var is_poison={!! $f_is_poison !!},
   is_status={!! $f_is_status !!},
   is_gr={!! $f_is_gr !!},
   is_po={!! $f_is_po !!};

   if(is_poison ===1){
     $("[name='poison_check").click();
   }


  if(is_status ===1){
    $("[name='status_check").click();
  }
  if(is_gr ===1){
    $("[name='gr_check").click();
  }
  if(is_po ===1){
    $("[name='po_check").click();
  }

  var a_c={!! json_encode($f_a_c_name) !!};
  var a_p={!! json_encode($f_a_p_number) !!};


  $('#available_customer').select2().val(a_c).trigger("change")
  $('#available_path_number').select2().val(a_p).trigger("change")


  var s_date = {!! json_encode($s_date) !!};
  var e_date = {!! json_encode($e_date) !!};
  var   rangePickr = $('.flatpickr-range');
  if (rangePickr.length) {
    rangePickr.flatpickr({
      mode: 'range',
      // dateFormat: 'm/d/Y',
      orientation: isRtl ? 'auto right' : 'auto left',

      {{--"minDate": "{{Carbon\Carbon::parse($available_day_s->created_at)->format('Y-m-d')}}",--}}
      {{--"maxDate": "{{Carbon\Carbon::parse($available_day_e->created_at)->format('Y-m-d')}}",--}}
      //
      {{-- defaultDate: [{!! $s_date !!}, {!!  $e_date!!}]--}}
       defaultDate:[s_date,e_date]

    });
  }

  function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable2");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++;
      } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }


</script>
@endsection

@section('content')


  <div class="card">
    <div class="card-body">
      <form class="needs-validation" novalidate id="filter_form" name="filter_form"
{{--              action="{{route(Route::current()->getName(),$farm->id)}}" --}}
            accept-charset="UTF-8">
      <div class="row">


        <div class="col-xl-6 col-12">
          <dl class="row mb-0">


            <dt class="col-sm-4 fw-bolder" style="margin-top: 10px;">Part Number</dt>
            <dd class="col-sm-8">

              <select multiple id="available_path_number" name="select_path_number[]" style="width:100px">
                @foreach( $available_part_number as $path)
                  <option value="{{$path->part_number}}">{{$path->part_number}}</option>
                @endforeach

              </select>
              <input type="checkbox" id="available_path_number_checkbox" > Select All
            </dd>


            <dt class="col-sm-4 fw-bolder" style="
    margin-top: 10px;">Customer</dt>
            <dd class="col-sm-8">

              <select multiple id="available_customer" name="select_customer[]" style="width:100px">
                @foreach( $available_customer as $data_customer)
                  <option value="{{$data_customer->name}}">{{$data_customer->name}}</option>
                @endforeach

              </select>
              <input type="checkbox" id="available_customer_checkbox" > Select All
            </dd>


            <dt class="col-sm-4 fw-bolder mb-2" style="
    margin-top: 10px;">Poison</dt>
            <dd class="col-sm-8 mb-2" style="
    margin-top: 10px;">
              <input type="checkbox" name="poison_check" class="mb-2" > Poison
            </dd>

            <dt class="col-sm-4 fw-bolder mb-2" style="
    margin-top: 10px;">Status</dt>
            <dd class="col-sm-8" style="
    margin-top: 10px;">

              <input type="checkbox" name="status_check" > Open
            </dd>
            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>


          </dl>
        </div>
        <div class="col-xl-6 col-12">
          <dl class="row mb-0">

            <dt class="col-sm-2 fw-bolder" style="
    margin-top: 10px;">Date Period</dt>
            <dd class="col-sm-10 mb-5"><input
                type="text"
                id="fp-range"
                name="range"
                class="form-control flatpickr-range"
                placeholder="YYYY-MM-DD to YYYY-MM-DD"
              /></dd>


            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>
            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>
            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>
            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>
            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>
            <dt class="col-sm-4 fw-bolder"></dt>
            <dd class="col-sm-8"></dd>
            <dt class="col-sm-4 fw-bolder mb-2" style="
                margin-top: 10px;">PO</dt>
            <dd class="col-sm-8 mb-2" style="
                margin-top: 10px;">
              <input type="checkbox" name="po_check" class="mb-2" > Yes
            </dd>

            <dt class="col-sm-4 fw-bolder mb-2" style="
                margin-top: 10px;">GR</dt>
            <dd class="col-sm-8 mb-2" style="
                margin-top: 10px;">
              <input type="checkbox" name="gr_check" class="mb-2" > Yes
            </dd>

          </dl>
        </div>

      </div>
      <div class="col-12">

        <button type="submit" class="btn btn-outline-primary col-12" >
          <i data-feather="search" class="me-25"></i>
          <span>Generate</span>
        </button><br/>
        <button onclick="ExportToExcel('xlsx')" class="btn btn-outline-primary col-12 mt-2" >
          <i data-feather= class="me-25"></i>
          <span>Export as Excel</span>
        </button>
      </div>

      </form>
    </div>
  </div>


  <div class="row" id="table-hover-row">
    <div class="col-12">
      <div class="card">
        <div class="table-responsive">
          <table class="table table-hover" id="myTable2">
            <thead>
            <tr>
              <th  onclick="sortTable(0)">#</th>
              <th  style="min-width:150px" onclick="sortTable(1)">Date</th>
              <th style="min-width:150px" onclick="sortTable(2)">OPF Number</th>
              <th onclick="sortTable(3)">Customer</th>
              <th onclick="sortTable(4)">SalesPerson</th>
              <th style="min-width:100px" onclick="sortTable(5)">Division</th>
              <th onclick="sortTable(6)">Po No</th>
              <th style="min-width:300px" onclick="sortTable(7)"> Part Number</th>
              <th  style="min-width:300px"  onclick="sortTable(8)">Description</th>
              <th onclick="sortTable(9)">Qty</th>
              <th style="min-width:100px" onclick="sortTable(10)">Unit Cost</th>
              <th style="min-width:150px" onclick="sortTable(11)">Total Cost</th>
              <th style="min-width:150px" onclick="sortTable(12)"> Unit Selling Price</th>
              <th style="min-width:150px" onclick="sortTable(13)"> Total Selling Price</th>
              <th style="min-width:150px" onclick="sortTable(14)">Gross Profit</th>
              <th style="min-width:150px" onclick="sortTable(15)">% Margin</th>
              <th style="min-width:100px" onclick="sortTable(16)">Stocks</th>
              <th style="min-width:100px" onclick="sortTable(17)">PO</th>
              <th style="min-width:100px" onclick="sortTable(18)">GR</th>
              <th style="min-width:100px" onclick="sortTable(19)">Poison</th>
              <th onclick="sortTable(20)">Status</th>

            </tr>
            </thead>
            <tbody>
            @php
              $_rowid=1;
              $total_profit=0;
              $total_gross=0;
              $total_received=0;
              $total_variance=0;
              $total_qty=0;
            @endphp
{{--            {{dd($datas)}}--}}
            @forelse($datas as $data)
              <tr>
                <td>{{str_pad($_rowid,2,"0",STR_PAD_LEFT)}}</td>
                <td>{{ Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}</td>


                <td>{{str_pad($data->opf_id,6,"0",STR_PAD_LEFT)}}</td>
                <td>{{$data->customer_name}}</td>
                <td>{{$data->sales_person}}</td>
                <td>{{$data->current_division}}</td>
                <td>{{$data->po_value}}</td>
                <td>{{$data->part_description}}</td>
                <td>{{$data->part_name}}</td>
                <td>{{$data->qty}}</td>
                <td>{{$data->unit_cost}}</td>
                <td>{{$data->total_cost}}</td>
                <td>{{$data->unit_selling_price}}</td>
                <td>{{$data->total_selling_price}}</td>
                <td>{{$data->profit}}</td>
                <td>
                  @if ( $data->margin>0 )
                    <span style="color:green">{{$data->margin}} %</span>
                  @else
                    <span style="color:red">{{$data->margin}} %</span>
                  @endif
                </td>
                <td>
                  @if ( $data->stock_check )
                    <span style="color:green">Yes</span>
                  @else
                    <span style="color:red">No</span>
                  @endif
                </td>
                <td>
                  @if ( $data->po_check )
                    <span style="color:green">Yes</span>
                  @else
                    <span style="color:red">No</span>
                  @endif
                </td>
                <td>
                  @if ( $data->gr_check )
                    <span style="color:green">Yes</span>
                  @else
                    <span style="color:red">No</span>
                  @endif
                </td>
                <td>
                  @if ( $data->is_poison )
                    <span style="color:red">Yes</span>
                  @else
                    <span style="">N/A</span>
                  @endif
                </td>
                <td>
                  @if ( $data->gr_status=='open' )
                    <span style="color:green">Open</span>
                  @else
                    <span style="">Close</span>
                  @endif
                </td>



              </tr>
              @php
                $_rowid++;
                $total_profit=$total_profit+$data->profit;
                $total_qty=$total_qty+$data->qty;
               // $total_received=$total_received+$data->received_cash;

              @endphp
            @empty
            @endforelse
{{--            <tr>--}}
{{--              <td></td>--}}
{{--              <td>Total</td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td>{{$total_qty}}</td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td></td>--}}
{{--              <td>{{bcdiv($total_profit,1,2)}}</td>--}}

{{--            </tr>--}}
{{--            <tr>--}}
{{--              <th>#</th>--}}
{{--              <th>Date</th>--}}
{{--              <th>OPF No</th>--}}
{{--              <th>Customer</th>--}}
{{--              <th>Po Number</th>--}}
{{--              <th>Part Number</th>--}}
{{--              <th>Description</th>--}}
{{--              <th>Qty</th>--}}
{{--              <th>Unit Cost</th>--}}
{{--              <th>Total Cost</th>--}}
{{--              <th>Unit Selling Price</th>--}}
{{--              <th>Total Selling Price</th>--}}
{{--              <th>Gross Profit</th>--}}
{{--              <th>% Margin</th>--}}
{{--              <th>Stocks</th>--}}
{{--              <th>PO</th>--}}
{{--              <th>GR</th>--}}
{{--              <th>Poison</th>--}}
{{--              <th>Status</th>--}}

{{--            </tr>--}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection

