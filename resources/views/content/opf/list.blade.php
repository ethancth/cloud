@extends('layouts/layoutMaster')

@section('title', 'OPF List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

@endsection

@php

  if (empty(Auth::user()->hasRole('Admin'))){
   $_user_role=0;
  }else
  { $_user_role=1;}
@endphp

@section('page-script')
  <script>
    /**
     * App OPF List (jquery)
     */

    'use strict';

    $(function () {
      // Variable declaration for table
      var dt_invoice_table = $('.opf-list-table'),
        statusbadge = {
          Draft: { title: 'Draft', class: 'bg-label-secondary' },
          Submitted: { title: 'Submitted', class: 'bg-label-info' },
          Complete: { title: 'Complete', class: 'bg-label-success' }
        };

      // Invoice datatable
      let user_role;
       user_role={!! $_user_role!!};
      if(user_role ===1){

        var valumn=  '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3" >>';
      }else{
        var valumn=  '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B >>';

      }
      if (dt_invoice_table.length) {
        var dt_invoice = dt_invoice_table.DataTable({
          // ajax: assetsPath + 'json/invoice-list.json',
          processing: true,
          serverSide: true,
          ajax: {
            url: baseUrl + 'opf-list'
          },
          columns: [
            // columns according to JSON
            { data: '' },
            { data: 'created_at' },
            { data: 'id' },
            { data: 'customer_name' },
            { data: 'total_po' },
            { data: 'opf_status' },
            { data: 'opf_status' },
            { data: 'current_division' },
            { data: 'progress' },
            { data: '' }
          ],
          columnDefs: [
            {
              // For Responsive
              className: 'control',
              responsivePriority: 5,
              searchable: false,
              targets: 0,
              render: function (data, type, full, meta) {
                return '';
              }
            },
            {
              // Invoice ID
              targets: 1,
              responsivePriority: 6,
              render: function (data, type, full, meta) {
                var $_id = full['id'];
                // Creates full output for row
                var $row_output = '<a href="' + baseUrl + 'app/opf/form/'+$_id+'">' + $_id + '</a>';
                return $row_output;
              }
            },
            {
              // Invoice status
              targets: 2,
              render: function (data, type, full, meta) {
                var $invoice_status = full['gr_status'],
                  $gross_profit = full['gross_profit'],
                  $gross_profit_percent = full['gross_profit_percent'],
                  $total_opf_item = full['total_opf_item'],
                  $total_do_check = full['total_do_check'],
                  $total_invoice_check = full['total_invoice_check'],
                  $total_gr_check = full['total_gr_check'],
                  $total_stock_check = full['total_stock_check'],
                  $total_po_check = full['total_po_check'],
                 $date = new Date(full['due_date']);
                var roleBadgeObj = {
                  open_old: '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30"><i class="ti ti-target ti-sm"></i></span>',
                  close1:
                    '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30"><i class="ti ti-device-floppy ti-sm"></i></span>',
                  'close2':
                    '<span class="badge badge-center rounded-pill bg-label-secondary w-px-30 h-px-30"><i class="ti ti-info-circle ti-sm"></i></span>',
                  'open':
                    '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30"><i class="ti ti-circle-half-2 ti-sm"></i></span>',
                  close: '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30"><i class="ti ti-chart-pie ti-sm"></i></span>',
                  close4:
                    '<span class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30"><i class="ti ti-arrow-down-circle ti-sm"></i></span>'
                };
                return (
                  "<span data-bs-toggle='tooltip' data-bs-html='true' title='<span> OPF" +
                  '<br> <span class="fw-medium">Date:</span> ' +
                  moment($date).format('DD MMM YYYY')+
                  '<br> <span class="fw-medium">Gross Profit :</span> ' +
                  $gross_profit +
                  '<br> <span class="fw-medium">Gross Profit :</span> ' +
                  $gross_profit_percent +"%"+
                  '<br> <span class="fw-medium">Stock Check :</span> ' +
                  $total_stock_check +"/"+$total_opf_item+
                  '<br> <span class="fw-medium">PO Check :</span> ' +
                  $total_po_check +"/"+$total_opf_item+
                  '<br> <span class="fw-medium">DO  Check :</span> ' +
                  $total_do_check +"/"+$total_opf_item+
                  '<br> <span class="fw-medium">Invoice Order Check :</span> ' +
                  $total_invoice_check +"/"+$total_opf_item+
                  '<br> <span class="fw-medium">GR Check :</span> ' +
                  $total_gr_check +"/"+$total_opf_item+
                  "</span>'>" +
                  roleBadgeObj[$invoice_status] +
                  '</span>'
                );
              }
            },
            {
              // Client name and Service
              targets: 3,
              responsivePriority: 4,
              render: function (data, type, full, meta) {
                var $name = full['customer_name'],
                 $_id = full['id'],
                  $service = full['pic_name'] +' '+full['pic_contact'],
                  $image = false,
                  $rand_num = Math.floor(Math.random() * 11) + 1,
                  $user_img = $rand_num + '.png',
                  $url= baseUrl + 'app/opf/form/'+$_id;
                if ($image === true) {
                  // For Avatar image
                  var $output =
                    '<img src="' + assetsPath + 'img/avatars/' + $user_img + '" alt="Avatar" class="rounded-circle">';
                } else {
                  // For Avatar badge
                  var stateNum = Math.floor(Math.random() * 6),
                    states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'],
                    $state = states[stateNum],
                    $name = full['customer_name'],
                    $initials = $name.match(/\b\w/g) || [];
                  $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                  $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
                }
                // Creates full output for row
                var $row_output =
                  '<div class="d-flex justify-content-start align-items-center">' +
                  '<div class="avatar-wrapper">' +
                  '<div class="avatar me-2">' +
                  $output +
                  '</div>' +
                  '</div>' +
                  '<div class="d-flex flex-column">' +
                  '<a href="'+$url+'" class="text-body text-truncate"><span class="fw-medium">' +
                  $name +
                  '</span></a>' +
                  '<small class="text-truncate text-muted">' +
                  $service +
                  '</small>' +
                  '</div>' +
                  '</div>';
                return $row_output;
              }
            },
            {
              // Total Invoice Amount
              targets: 4,
              render: function (data, type, full, meta) {
                var $total = full['total_po'];
                var currency = full['currency'];
                $total= $total.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
                return '<span class="d-none">' + $total + '</span>RM' + $total;
              }
            },
            {
              // Due Date
              targets: 5,
              render: function (data, type, full, meta) {
                var $due_date = new Date(full['due_date']);
                // Creates full output for row
                var $row_output =
                  '<span class="d-none">' +
                  moment($due_date).format('YYYYMMDD') +
                  '</span>' +
                  moment($due_date).format('DD MMM YYYY');
                $due_date;
                return $row_output;
              }
            },
            {
              // Client Balance/Status
              targets: 6,
              orderable: true,
              render: function (data, type, full, meta) {



                var $opf_status = full['opf_status'];
                return (
                  '<span class="badge ' +
                  statusbadge[$opf_status].class +
                  '" text-capitalized>' +
                  statusbadge[$opf_status].title +
                  '</span>'
                );
              }
            },

             {
              // Client Balance/Status
              targets: 8,
              orderable: true,

               render: function (data, type, full, meta) {
                 var $progress = full['progress'] + '%',
                   $color;
                 switch (true) {
                   case full['progress'] < 25:
                     $color = 'bg-danger';
                     break;
                   case full['progress'] < 50:
                     $color = 'bg-warning';
                     break;
                   case full['progress'] < 75:
                     $color = 'bg-info';
                     break;
                   case full['progress'] <= 100:
                     $color = 'bg-success';
                     break;
                 }
                 return (
                   '<div class="d-flex flex-column"><small class="mb-1">' +
                   $progress +
                   '</small>' +
                   '<div class="progress w-100 me-3" style="height: 6px;">' +
                   '<div class="progress-bar ' +
                   $color +
                   '" style="width: ' +
                   $progress +
                   '" aria-valuenow="' +
                   $progress +
                   '" aria-valuemin="0" aria-valuemax="100"></div>' +
                   '</div>' +
                   '</div>'
                 );
               }

            },

            {
              // Client Balance/Status
              targets: 7,
              orderable: false,
              render: function (data, type, full, meta) {
                var $salesperson = full['sales_person'];
                var $division = full['current_division'];

                var $row_output =
                  '<div class="d-flex justify-content-start align-items-center">' +
                  '<div class="avatar-wrapper">' +
                  '</div>' +
                  '<div class="d-flex flex-column">' +
                  '<a href="#" class="text-body text-truncate"><span class="fw-medium">' +
                  $salesperson +
                  '</span></a>' +
                  '<small class="text-truncate text-muted">' +
                  $division +
                  '</small>' +
                  '</div>' +
                  '</div>';
                return $row_output;

              //    return '<span class="d-none">' + $balance + '</span>' + $balance;

              }
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              searchable: false,
              orderable: false,
              render: function (data, type, full, meta) {
                var $_id = full['id'];
                return (
                  '<div class="d-flex align-items-center">' +
                  '<a href="' +
                  baseUrl +
                  'app/opf/form/'+$_id+'" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Edit OPF"><i class="ti ti-edit mx-2 ti-sm"></i></a>' +
                  '<div class="dropdown">' +

                  '</div>' +
                  '</div>'
                );
              }
            }
          ],

          order: [[1, 'desc']],
          dom:
            '<"row mx-1"' +
            valumn+
            '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
          language: {
            sLengthMenu: 'Show _MENU_',
            search: '',
            searchPlaceholder: 'Search..'
          },
          // Buttons with Dropdown
          buttons: [
            {
              text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Create New OPF</span>',
              className: 'btn btn-primary',
              action: function (e, dt, button, config) {
                window.location = baseUrl + 'app/opf/create';
              }
            }
          ],

          // For responsive popup
          // responsive: {
          //   details: {
          //     display: $.fn.dataTable.Responsive.display.modal({
          //       header: function (row) {
          //         var data = row.data();
          //         return 'Details';
          //       }
          //     }),
          //     type: 'column',
          //     renderer: function (api, rowIdx, columns) {
          //       var data = $.map(columns, function (col, i) {
          //         return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
          //           ? '<tr data-dt-row="' +
          //           col.rowIndex +
          //           '" data-dt-column="' +
          //           col.columnIndex +
          //           '">' +
          //           '<td>' +
          //           col.title +
          //           ':' +
          //           '</td> ' +
          //           '<td>' +
          //           col.data +
          //           '</td>' +
          //           '</tr>'
          //           : '';
          //       }).join('');
          //
          //       return data ? $('<table class="table"/><tbody />').append(data) : false;
          //     }
          //   }
          // },


          // initComplete: function () {
          //   // Adding role filter once table initialized
          //   this.api()
          //     .columns(6)
          //     .every(function () {
          //       var column = this;
          //       var select = $(
          //         '<select id="UserRole" class="form-select"><option value=""> Select Status </option></select>'
          //       )
          //         .appendTo('.invoice_status')
          //         .on('change', function () {
          //           var val = $.fn.dataTable.util.escapeRegex($(this).val());
          //           column.search(val ? '^' + val + '$' : '', false, false).draw();
          //         });
          //
          //       column
          //         .data()
          //         .unique()
          //         .sort()
          //         .each(function (d, j) {
          //           select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
          //         });
          //     });
          // }
        });
      }

      // On each datatable draw, initialize tooltip
      dt_invoice_table.on('draw.dt', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl, {
            boundary: document.body
          });
        });
      });

      // Delete Record
      $('.opf-list-table tbody').on('click', '.delete-record', function () {
        dt_invoice.row($(this).parents('tr')).remove().draw();
      });

      // Filter form control to default size
      // ? setTimeout used for multilingual table initialization
      setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
      }, 300);
    });


  </script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">OPF /</span> List
  </h4>

  <!-- Invoice List Widget -->

  @if(Auth::user()->hasRole('Boss'))

  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">
      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1">
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
              <div>
                <h3 class="mb-1">{{$distinct_customer}}</h3>
                <p class="mb-0">Opf</p>
              </div>
              <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-info rounded"><i class="ti ti-user ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none me-4">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
              <div>
                <h3 class="mb-1">{{$totalCount}}</h3>
                <p class="mb-0">Opf</p>
              </div>
              <span class="avatar me-lg-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-file-invoice ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
              <div>
                <h3 class="mb-1">RM {{number_format($totalPO)}}</h3>
                <p class="mb-0">Total PO</p>
              </div>
              <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-success rounded"><i class="ti ti-checks ti-md"></i></span>
            </span>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h3 class="mb-1">RM {{number_format($totalProfit,2)}}</h3>
                <p class="mb-0">Profit</p>
              </div>
              <span class="avatar">
              <span class="avatar-initial bg-label-info rounded"><i class="ti ti-circle-off ti-md"></i></span>
            </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Invoice List Table -->
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="opf-list-table table border-top">
        <thead>
        <tr>
          <th></th>
          <th>#ID</th>
          <th><i class='ti ti-trending-up text-secondary'></i></th>
          <th>Customer</th>
          <th>Po Value</th>
          <th class="text-truncate">Due Date</th>
          <th>Status</th>
          <th>Sales Person</th>
          <th>Progres</th>
          <th class="cell-fit">Action</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>

@endsection
