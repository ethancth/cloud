<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="" xml:lang="">
<head>
  <title></title>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <br/>
  <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css">
  <style type="text/css">
    <!--
    p {margin: 0; padding: 0;}	.ft10{font-size:13px;font-family:Times;color:#404040;}
    .ft11{font-size:10px;font-family:Times;color:#404040;}
    .ft12{font-size:10px;font-family:Times;color:#0563c1;}
    .ft13{font-size:22px;font-family:Times;color:#404040;}
    .ft14{font-size:13px;font-family:Times;color:#404040;}
    .ft15{font-size:16px;font-family:Times;color:#000000;}
    .ft16{font-size:19px;font-family:Times;color:#000000;}
    .ft17{font-size:13px;line-height:18px;font-family:Times;color:#404040;}
    .ft18{font-size:13px;line-height:18px;font-family:Times;color:#404040;}
    .ft19{font-size:13px;line-height:19px;font-family:Times;color:#404040;}
    -->
  </style>
</head>
<body bgcolor="#A0A0A0" vlink="blue" link="blue">
<div id="page1-div" style="position:relative;width:892px;height:1261px;">
  <img width="892" height="1261" src="{{ asset('assets/target001.png') }}" alt="background image"/>
  <p style="position:absolute;top:110px;left:54px;white-space:nowrap" class="ft10">&#160; &#160;</p>
  <p style="position:absolute;top:125px;left:54px;white-space:nowrap" class="ft10">_________________________________________________________________________________________________________</p>
  <p style="position:absolute;top:1194px;left:276px;white-space:nowrap" class="ft10">&#160; &#160;</p>
  <p style="position:absolute;top:1194px;left:330px;white-space:nowrap" class="ft10">GAMMA&#160;SCIENTIFIC RESEARCH SDN&#160;BHD &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;Page&#160;1&#160;of&#160;2</p>
  <p style="position:absolute;top:26px;left:392px;white-space:nowrap" class="ft11"><b>GAMMA SCIENTIFIC RESEARCH&#160;SDN. BHD. (942113-P)</b></p>
  <p style="position:absolute;top:53px;left:392px;white-space:nowrap" class="ft11"><b>11A-2 ,&#160;Jalan PJS 8/5</b></p>
  <p style="position:absolute;top:53px;left:554px;white-space:nowrap" class="ft11"><b>Tel: &#160; &#160; &#160; &#160; +603-5638 8288</b></p>
  <p style="position:absolute;top:67px;left:392px;white-space:nowrap" class="ft11"><b>Mentari&#160;Business Park</b></p>
  <p style="position:absolute;top:67px;left:554px;white-space:nowrap" class="ft11"><b>Fax: &#160; &#160; &#160; &#160;+603-5638 8278</b></p>
  <p style="position:absolute;top:82px;left:392px;white-space:nowrap" class="ft11"><b>Bandar&#160;Sunway</b></p>
  <p style="position:absolute;top:82px;left:554px;white-space:nowrap" class="ft11"><b>Email: &#160; &#160;&#160;</b></p>
  <p style="position:absolute;top:82px;left:604px;white-space:nowrap" class="ft12"><a href="mailto:k.yct@gammascientific.com.my"><b>k.yct@gammascientific.com.my</b></a></p>
  <p style="position:absolute;top:97px;left:392px;white-space:nowrap" class="ft11"><b>46150&#160;Petaling&#160;Jaya</b></p>
  <p style="position:absolute;top:97px;left:554px;white-space:nowrap" class="ft11"><b>URL: &#160; &#160; &#160;</b></p>
  <p style="position:absolute;top:97px;left:602px;white-space:nowrap" class="ft12"><a href="http://www.gammascientific.com.my"><b>www.gammascientific.com.my</b></a></p>
  <p style="position:absolute;top:145px;left:62px;white-space:nowrap" class="ft13"><b>OPF #</b></p>
  <p style="position:absolute;top:196px;left:62px;white-space:nowrap" class="ft18"><b>Invoice To:<br/></b>{{$opf->customer_name}}<br/>{{$opf->customer_billing_address}}<br/>{{$opf->pic_email}}</p>
  <p style="position:absolute;top:196px;left:509px;white-space:nowrap" class="ft18"><b>Delivery&#160;To:<br/></b>{{$opf->customer_name}}<br/>{{$opf->customer_delivery_address}}<br/>{{$opf->pic_email}}</p>
  <p style="position:absolute;top:358px;left:62px;white-space:nowrap" class="ft18"><b>Po Number&#160;#&#160;</b>{{$opf->po_value}}<br/><b>Create Date:&#160;</b>{{$opf->created_at->format('d/m/Y')}}<br/><b>Due Date:&#160;&#160;</b>30<br/><b>Currency:&#160;&#160;</b>{{$opf->currency}} ({{$opf->currency_rate}})</p>
  <p style="position:absolute;top:378px;left:392px;white-space:nowrap" class="ft18"><b>PIC:&#160;</b>{{$opf->pic_name}}<br/><b>Email:&#160;</b>{{$opf->pic_email}}<br/><b>Contact:</b>&#160;{{$opf->contact}}&#160;</p>

  <div class="margin-top"style="position:relative;">
    <table class="products" style="position:relative;">
      <tr>
        <th>Qty</th>
        <th>Description</th>
        <th>Price</th>
      </tr>
      <tr class="items"  style="position:relative;">
        @foreach($data as $item)
          <td>
            {{ $item['quantity'] }}
          </td>
          <td>
            {{ $item['description'] }}
          </td>
          <td>
            {{ $item['price'] }}
          </td>
        @endforeach
      </tr>
    </table>
  </div>

  <p style="position:absolute;top:468px;left:77px;white-space:nowrap" class="ft11"><b>No</b></p>
  <p style="position:absolute;top:468px;left:185px;white-space:nowrap" class="ft11"><b>DESCRIPTION</b></p>
  <p style="position:absolute;top:468px;left:512px;white-space:nowrap" class="ft11"><b>QTY</b></p>
  <p style="position:absolute;top:468px;left:589px;white-space:nowrap" class="ft11"><b>UNIT PRICE</b></p>
  <p style="position:absolute;top:468px;left:691px;white-space:nowrap" class="ft11"><b>Discount</b></p>
  <p style="position:absolute;top:468px;left:777px;white-space:nowrap" class="ft11"><b>AMOUNT</b></p>
  <p style="position:absolute;top:578px;left:81px;white-space:nowrap" class="ft10">1</p>
  <p style="position:absolute;top:572px;left:185px;white-space:nowrap" class="ft18">Masterflex<br/>07526-10<br/>Masterflex L/S®&#160;MasterSense™ Drive&#160;with&#160;<br/>EtherNet/IP™ and MasterflexLive®,&#160;ABS Plastic&#160;<br/>Housing,&#160;0.1&#160;to 600&#160;rpm;&#160;115/230&#160;VAC</p>
  <p style="position:absolute;top:578px;left:518px;white-space:nowrap" class="ft10">1</p>
  <p style="position:absolute;top:578px;left:577px;white-space:nowrap" class="ft10">RM27,776.00</p>
  <p style="position:absolute;top:578px;left:700px;white-space:nowrap" class="ft10">20%</p>
  <p style="position:absolute;top:578px;left:760px;white-space:nowrap" class="ft10">RM22,220.80</p>
  <p style="position:absolute;top:670px;left:81px;white-space:nowrap" class="ft10">2</p>
  <p style="position:absolute;top:664px;left:185px;white-space:nowrap" class="ft18">Masterflex<br/>07514-10<br/>Masterflex®&#160;L/S®&#160;Easy-Load®&#160;Pump Heads for&#160;<br/>Precision Tubing,&#160;Avantor®</p>
  <p style="position:absolute;top:670px;left:518px;white-space:nowrap" class="ft10">2</p>
  <p style="position:absolute;top:670px;left:580px;white-space:nowrap" class="ft10">RM2,926.00</p>
  <p style="position:absolute;top:670px;left:700px;white-space:nowrap" class="ft10">20%</p>
  <p style="position:absolute;top:670px;left:764px;white-space:nowrap" class="ft10">RM4,681.60</p>
  <p style="position:absolute;top:744px;left:81px;white-space:nowrap" class="ft10">3</p>
  <p style="position:absolute;top:738px;left:185px;white-space:nowrap" class="ft18">Masterflex<br/>07013-05<br/>L/S®&#160;Easy-Load®&#160;Pump Head Mounting&#160;<br/>Hardware,&#160;Two Pump Heads,&#160;Stainless Steel;&#160;<br/>2/Set</p>
  <p style="position:absolute;top:744px;left:518px;white-space:nowrap" class="ft10">1</p>
  <p style="position:absolute;top:744px;left:586px;white-space:nowrap" class="ft10">RM318.00</p>
  <p style="position:absolute;top:744px;left:704px;white-space:nowrap" class="ft10">0%</p>
  <p style="position:absolute;top:744px;left:770px;white-space:nowrap" class="ft10">RM318.00</p>
  <p style="position:absolute;top:878px;left:645px;white-space:nowrap" class="ft15"><b>Subtotal:</b></p>
  <p style="position:absolute;top:878px;left:748px;white-space:nowrap" class="ft15"><b>RM27,220.40</b></p>
  <p style="position:absolute;top:906px;left:651px;white-space:nowrap" class="ft16"><b>TOTAL:&#160;&#160;RM27,220.40</b></p>
  <p style="position:absolute;top:949px;left:54px;white-space:nowrap" class="ft10">Term&#160;and Conditions:</p>
  <p style="position:absolute;top:968px;left:62px;white-space:nowrap" class="ft10">Price</p>
  <p style="position:absolute;top:968px;left:171px;white-space:nowrap" class="ft10">:&#160;All price&#160;quoted in Ringgit&#160;Malaysia</p>
  <p style="position:absolute;top:987px;left:62px;white-space:nowrap" class="ft10">Validity</p>
  <p style="position:absolute;top:987px;left:171px;white-space:nowrap" class="ft10">:&#160;30&#160;Days</p>
  <p style="position:absolute;top:1006px;left:62px;white-space:nowrap" class="ft10">Delivery&#160;Period</p>
  <p style="position:absolute;top:1006px;left:171px;white-space:nowrap" class="ft10">:&#160;8-10&#160;weeks</p>
  <p style="position:absolute;top:1025px;left:62px;white-space:nowrap" class="ft10">Payment&#160;Term</p>
  <p style="position:absolute;top:1025px;left:171px;white-space:nowrap" class="ft10">:&#160;90&#160;Days</p>
  <p style="position:absolute;top:1045px;left:62px;white-space:nowrap" class="ft10">Delivery&#160;Term</p>
  <p style="position:absolute;top:1045px;left:171px;white-space:nowrap" class="ft10">:&#160;Nett&#160;Delivered</p>
  <p style="position:absolute;top:1064px;left:62px;white-space:nowrap" class="ft10">Cancellation</p>
  <p style="position:absolute;top:1064px;left:171px;white-space:nowrap" class="ft10">:&#160;30%&#160;restocking&#160;for&#160;order&#160;cancellation</p>
  <p style="position:absolute;top:1082px;left:54px;white-space:nowrap" class="ft19">Thank&#160;you.<br/>Yours faithfully,&#160;</p>
</div>
</body>
</html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="" xml:lang="">
<head>
  <title></title>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <br/>
  <style type="text/css">
    <!--
    p {margin: 0; padding: 0;}	.ft20{font-size:13px;font-family:Times;color:#404040;}
    .ft21{font-size:10px;font-family:Times;color:#404040;}
    .ft22{font-size:10px;font-family:Times;color:#0563c1;}
    .ft23{font-size:13px;font-family:Times;color:#404040;}
    .ft24{font-size:13px;font-family:Times;color:#0563c1;}
    .ft25{font-size:13px;font-family:Times;color:#000000;}
    .ft26{font-size:13px;line-height:19px;font-family:Times;color:#404040;}
    -->
  </style>
</head>
<body bgcolor="#A0A0A0" vlink="blue" link="blue">
<div id="page2-div" style="position:relative;width:892px;height:1261px;">
  <img width="892" height="1261" src="{{ asset('assets/target002.png') }}" alt="background image"/>
  <p style="position:absolute;top:110px;left:54px;white-space:nowrap" class="ft20">&#160; &#160;</p>
  <p style="position:absolute;top:125px;left:54px;white-space:nowrap" class="ft20">_________________________________________________________________________________________________________</p>
  <p style="position:absolute;top:1194px;left:276px;white-space:nowrap" class="ft20">&#160; &#160;</p>
  <p style="position:absolute;top:1194px;left:330px;white-space:nowrap" class="ft20">GAMMA&#160;SCIENTIFIC RESEARCH SDN&#160;BHD &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;Page&#160;2&#160;of&#160;2</p>
  <p style="position:absolute;top:26px;left:392px;white-space:nowrap" class="ft21"><b>GAMMA SCIENTIFIC RESEARCH&#160;SDN. BHD. (942113-P)</b></p>
  <p style="position:absolute;top:53px;left:392px;white-space:nowrap" class="ft21"><b>11A-2 ,&#160;Jalan PJS 8/5</b></p>
  <p style="position:absolute;top:53px;left:554px;white-space:nowrap" class="ft21"><b>Tel: &#160; &#160; &#160; &#160; +603-5638 8288</b></p>
  <p style="position:absolute;top:67px;left:392px;white-space:nowrap" class="ft21"><b>Mentari&#160;Business Park</b></p>
  <p style="position:absolute;top:67px;left:554px;white-space:nowrap" class="ft21"><b>Fax: &#160; &#160; &#160; &#160;+603-5638 8278</b></p>
  <p style="position:absolute;top:82px;left:392px;white-space:nowrap" class="ft21"><b>Bandar&#160;Sunway</b></p>
  <p style="position:absolute;top:82px;left:554px;white-space:nowrap" class="ft21"><b>Email: &#160; &#160;&#160;</b></p>
  <p style="position:absolute;top:82px;left:604px;white-space:nowrap" class="ft22"><a href="mailto:k.yct@gammascientific.com.my"><b>k.yct@gammascientific.com.my</b></a></p>
  <p style="position:absolute;top:97px;left:392px;white-space:nowrap" class="ft21"><b>46150&#160;Petaling&#160;Jaya</b></p>
  <p style="position:absolute;top:97px;left:554px;white-space:nowrap" class="ft21"><b>URL: &#160; &#160; &#160;</b></p>
  <p style="position:absolute;top:97px;left:602px;white-space:nowrap" class="ft22"><a href="http://www.gammascientific.com.my"><b>www.gammascientific.com.my</b></a></p>
  <p style="position:absolute;top:143px;left:54px;white-space:nowrap" class="ft26"><i><b>for Gamma&#160;Scientific&#160;Research Sdn. Bhd.<br/></b></i>Quoted by&#160;Kenny<a href="mailto:k.yct@gammascientific.com.my">&#160;Tan YC -&#160;</a></p>
  <p style="position:absolute;top:163px;left:215px;white-space:nowrap" class="ft24"><a href="mailto:k.yct@gammascientific.com.my">k.yct@gammascientific.com.my</a></p>
  <p style="position:absolute;top:183px;left:54px;white-space:nowrap" class="ft25">Mobile:&#160;+6012-6460203</p>
  <p style="position:absolute;top:214px;left:54px;white-space:nowrap" class="ft20">&#160;&#160;</p>
</div>
</body>
</html>
