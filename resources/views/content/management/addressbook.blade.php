@extends('layouts/layoutMaster')

@section('title', 'Address Book')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script>
  /**
   * Page User List
   */

  'use strict';

  // Datatable (jquery)
  $(function () {
    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),
      select2 = $('.select2'),
      userView ='#',
      offCanvasForm = $('#offcanvasAddAddress');
    var _cid = '{{$company->id}}';





    // ajax setup
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Users datatable
    if (dt_user_table.length) {
      var dt_user = dt_user_table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: `${baseUrl}company/${_cid}/addressbook/detail`
        },
        columns: [
          // columns according to JSON
          { data: '' },
          { data: 'id' },
          { data: 'description' },
          { data: 'billing_address' },
          { data: 'delivery_address' },
          { data: 'action' }
        ],
        columnDefs: [
          {
            // For Responsive
            className: 'control',
            searchable: false,
            orderable: false,
            responsivePriority: 2,
            targets: 0,
            render: function (data, type, full, meta) {
              return '';
            }
          },
          {
            searchable: false,
            orderable: false,
            targets: 1,
            render: function (data, type, full, meta) {
              return `<span>${full.fake_id}</span>`;
            }
          },
          {
            // User full name
            targets: 2,
            responsivePriority: 4,
            render: function (data, type, full, meta) {
              var $name = full['description'];

              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $name = full['description'],
           //     $initials = $name.match(/\b\w/g) || [],
                $output;
           //   $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
             // $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $name + '</span>';

              // Creates full output for row
              var $row_output =
                '<div class="d-flex justify-content-start align-items-center first-row">' +
                '<div class="avatar-wrapper">' +
                '</div>' +
                '<div class="d-flex flex-column">' +
                '<a href="' +
                userView +
                '" class="text-body text-truncate"><span class="fw-medium">' +
                $name +
                '</span></a>' +
                '</div>' +
                '</div>';
              return $row_output;
            }
          },
          {
            // User email
            targets: 3,
            render: function (data, type, full, meta) {
              var $email = full['billing_address'];

              return '<span class="user-email">' + $email + '</span>';
            }
          },
          {
            // User email
            targets: 4,
            render: function (data, type, full, meta) {
              var $email = full['delivery_address'];

              return '<span class="user-email">' + $email + '</span>';
            }
          },
          {
            // Actions
            targets: -1,
            title: 'Actions',
            searchable: false,
            orderable: false,
            render: function (data, type, full, meta) {
              return (
                '<div class="d-inline-block text-nowrap">' +
                `<button class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddAddress"><i class="ti ti-edit"></i></button>` +
                `<button class="btn btn-sm btn-icon delete-record" data-id="${full['id']}"><i class="ti ti-trash"></i></button>` +
                '</div>'
              );
            }
          }
        ],
        order: [[2, 'desc']],
        dom:
          '<"row mx-2"' +
          '<"col-md-2"<"me-3"l>>' +
          '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
          '>t' +
          '<"row mx-2"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: '_MENU_',
          search: '',
          searchPlaceholder: 'Search..'
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-label-primary dropdown-toggle mx-3',
            text: '<i class="ti ti-logout rotate-n90 me-2"></i>Export',
            buttons: [
              {
                extend: 'print',
                title: 'Address Book',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3,4],
                  // prevent avatar to be print
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('first-row')) {
                          result = result + item.lastChild.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                },
                customize: function (win) {
                  //customize print view for dark
                  $(win.document.body)
                    .css('color', config.colors.headingColor)
                    .css('border-color', config.colors.borderColor)
                    .css('background-color', config.colors.body);
                  $(win.document.body)
                    .find('table')
                    .addClass('compact')
                    .css('color', 'inherit')
                    .css('border-color', 'inherit')
                    .css('background-color', 'inherit');
                }
              },
              {
                extend: 'excel',
                title: 'Address Book',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3,4],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList.contains('first-row')) {
                          result = result + item.lastChild.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              },
              {
                extend: 'pdf',
                title: 'Address Book',
                text: '<i class="ti ti-file-text me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3,4],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList.contains('first-row')) {
                          result = result + item.lastChild.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              },
              {
                extend: 'copy',
                title: 'Address Book',
                text: '<i class="ti ti-copy me-1" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3],
                  // prevent avatar to be copy
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList.contains('first-row')) {
                          result = result + item.lastChild.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              }
            ]
          },
          {
            text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New Address Book</span>',
            className: 'add-new btn btn-primary',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddAddress'
            }
          }
        ],
        // For responsive popup
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return 'Details of ' + data['name'];
              }
            }),
            type: 'column',
            renderer: function (api, rowIdx, columns) {
              var data = $.map(columns, function (col, i) {
                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                  ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  '<td>' +
                  col.title +
                  ':' +
                  '</td> ' +
                  '<td>' +
                  col.data +
                  '</td>' +
                  '</tr>'
                  : '';
              }).join('');

              return data ? $('<table class="table"/><tbody />').append(data) : false;
            }
          }
        }
      });
    }

    // Delete Record
    $(document).on('click', '.delete-record', function () {
      var _id = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');

      // hide responsive modal in small screen
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }

      // sweetalert for confirmation of delete
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary me-3',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          // delete the data
          $.ajax({
            type: 'DELETE',


            url: `${baseUrl}company/${_cid}/addressbook/${_id}`,
            success: function () {
              dt_user.draw();
            },
            error: function (error) {
              console.log(error);
            }
          });

          // success sweetalert
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'The Address has been deleted!',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The Address is not deleted!',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    // edit record
    $(document).on('click', '.edit-record', function () {

      var _id = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');

      // hide responsive modal in small screen
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }

      // changing the title of offcanvas
      $('#offcanvasAddAddressLabel').html('Edit Address');

      // get data

      $.get(`${baseUrl}company/${_cid}/addressbook\/${_id}\/edit`, function (data) {
        $('#_id').val(data.id);
        $('#_name').val(data.description);
        $('#billing_address').text(data.billing_address);
        $('#delivery_address').text(data.delivery_address);
      });
    });

    // changing the title
    $('.add-new').on('click', function () {
      $('#_id').val(''); //reseting input field
      $('#_name').val('');
      $('#billing_address').text('');
      $('#delivery_address').text('');
      $('#offcanvasAddAddressLabel').html('Add New Address');
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);

    // validating form and updating user's data
    const addNewRecordForm = document.getElementById('addNewRecordForm');

    // user form validation
    const fv = FormValidation.formValidation(addNewRecordForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter address description'
            }
          }
        },

        billing_address: {
          validators: {
            notEmpty: {
              message: 'Billing address required.'
            }
          }
        },
        delivery_address: {
          validators: {
            notEmpty: {
              message: 'Delivery address required.'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.mb-3';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // adding or updating user when form successfully validate
      $.ajax({
        data: $('#addNewRecordForm').serialize(),
        url: `${baseUrl}company/${_cid}/addressbook`,
        type: 'POST',
        success: function (status) {
          dt_user.draw();
          offCanvasForm.offcanvas('hide');

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status}!`,
            text: `Address ${status} Successfully.`,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (err) {
          offCanvasForm.offcanvas('hide');
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'Both Address should be unique.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    // clearing form data when offcanvas hidden
    offCanvasForm.on('hidden.bs.offcanvas', function () {
      // fv.resetForm(true);
    });

  });


</script>
@endsection

@section('content')

<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">{{$company->name}} - Address Book</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th>#</th>
          <th>Description</th>
          <th>Billing Address</th>
          <th>Delivery Address</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new record -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddAddress" aria-labelledby="offcanvasAddAddressLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasAddAddressLabel" class="offcanvas-title">Add</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
      <form class=" pt-0" id="addNewRecordForm">
        <input type="hidden" name="id" id="_id">
        <div class="mb-3">
          <label class="form-label" for="_name">Address Description</label>
          <input type="text" class="form-control" id="_name" placeholder="Prefer Name" name="name" aria-label="" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="billing_address">Billing Address</label>
          <textarea  class="form-control" id="billing_address" placeholder="Billing Address" name="billing_address" aria-label="" rows="4"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label" for="delivery_address">Delivery Address</label>
          <textarea  class="form-control" id="delivery_address" placeholder="Delivery Address" name="delivery_address" aria-label="" rows="4"></textarea>
        </div>

        <div class="mb-3">
          <label class="switch switch-primary">
            <input type="checkbox" class="switch-input" name="set_default_address" />
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
            <span class="switch-label">Set As Default Address</span>
          </label>
        </div>
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection
