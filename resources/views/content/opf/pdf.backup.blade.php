<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>OPF #</title>
  <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css">
</head>
<body>
<table class="w-full">
  <tr>
    <td class="w-half">
      <img src="{{ asset('assets/gamma_scientific_logo.png') }}" alt="GAMMA SCIENTIFIC RESEARCH SDN. BHD." width="200" />
    </td>
    <td class="w-half">
      <h2>OPF# {{str_pad($opf->id, 6, '0', STR_PAD_LEFT) }}</h2>
    </td>
  </tr>
</table>
<div class="margin-top">
  <table class="w-full">
    <tr>
      <td class="w-half">
        <div><h4>Invoice to:</h4></div>
        <div>{{$opf->customer_name}}</div>
        <div>{{$opf->customer_billing_address}}</div>
      </td>
      <td class="w-half">
        <div><h4>Delivery To:</h4></div>
        <div>{{$opf->customer_name}}</div>
        <div>{{$opf->customer_delivery_address}}</div>
      </td>
    </tr>
  </table>
</div>


<div class="margin-top">
  <table class="w-full">
    <tr>

      <td class="w-half">
        <div><b>PO : #</b>{{$opf->po_value}}</div>
        <div><b>Due Date</b> {{$opf->due_date}}</div>
        <div><b>Currenct </b> {{$opf->currency}}</div>
        <div><b>Sales Person:</b> {{$opf->sales_person}} [{{$opf->current_division}}]</div>
      </td>
      <td class="w-half">
        <div><b>PIC:</b>{{$opf->pic_name}}</div>
        <div><b>Contact:</b>{{$opf->contact}}</div>
        <div><b>Email:</b>{{$opf->pic_email}}</div>
      </td>
    </tr>
  </table>
</div>
<hr>

<div class="margin-top">
  <table class="products" style="table-layout:fixed">
    <tr>
      <th>No</th>
      <th>DESCRIPTION</th>
      <th>Qty</th>
      <th>Unit Price</th>
      <th>Unit Selling Price</th>
      <th>Total Selling Price</th>
    </tr>
    @php
      $var_id=1;
    @endphp
    @foreach($opf->item as $item)

      <tr class="items">
        <td>
          {{ $var_id }}
        </td>
        <td>
          {{ $item['part_description'] }}<br>
          {{ $item['part_name'] }}<br>
          {{ $item['supplier_name'] }}
        </td>
        <td>
          {{ $item['qty'] }}
        </td>
        <td>
          {{ $item['unit_cost'] }}
        </td>
        <td>
          {{ $item['unit_selling_price'] }}
        </td>
        <td>
          {{ $item['total_selling_price'] }}
        </td>

      </tr>
      @php
        $var_id++;
      @endphp
      @endforeach
      </tr>
  </table>
</div>

<div class="total">
  Total PO value:  <span class="number">RM{{number_format($opf->total_po,2)}}</span>
</div>
<div class="total">
  Total Cost of Goods: <span class="number">RM{{number_format($opf->total_cost_of_goods,2)}}</span>
</div>
<div class="total">
  Duty/Taxes: <span class="number">RM{{number_format($opf->total_tax,2)}}</span>
</div>
<div class="total">
  Shipping charges: <span class="number">RM{{number_format($opf->total_shipping,2)}}</span>
</div>
<div class="total">
  Gross Profit: <span class="number">RM{{number_format($opf->gross_profit,2)}}</span>
</div><div class="total">
  % of Gross profit: <span class="number">{{$opf->gross_profit_percent}}%</span>
</div>

<div class="footer margin-top">
  <div>Thank you</div>
  <div>&copy; Laravel Daily</div>
</div>
</body>
</html>
