@extends('layouts/layoutMaster')

@section('title', 'User Management')

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
      userView = baseUrl + 'user-management',
      offCanvasForm = $('#offcanvasAddUser');

    if (select2.length) {
      var $this = select2;
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select Country',
        dropdownParent: $this.parent()
      });
    }

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
          url: baseUrl + 'user-list'
        },
        columns: [
          // columns according to JSON
          { data: '' },
          { data: 'id' },
          { data: 'name' },
          { data: 'email' },
          { data: 'role' },
          { data: 'email_verified_at' },
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
              var $name = full['name'],
              $image = full['profile_pic'],
              $role = full['division_name'];


              if ($image) {
                // For Avatar image
                var $output =
                  '<img src="' + $image + '" alt="Avatar" height="32" width="32" class="rounded-circle">';
              } else {
                // For Avatar badge
                var stateNum = Math.floor(Math.random() * 6);
                var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                var $state = states[stateNum],
                  $initials = $name.match(/\b\w/g) || [];
                $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
              }


              var $row_output =
                '<div class="d-flex justify-content-start align-items-center">' +
                '<div class="avatar-wrapper">' +
                '<div class="avatar me-2">' +
                $output +
                '</div>' +
                '</div>' +
                '<div class="d-flex flex-column">' +
                '<a href="'+userView+'" class="text-body text-truncate"><span class="fw-medium">' +
                $name +
                '</span></a>' +
                '<small class="text-truncate text-muted">' +
                $role +
                '</small>' +
                '</div>' +
                '</div>';
              return $row_output;
            }
          },
          {
            // User email
            targets: 3,
            render: function (data, type, full, meta) {
              var $email = full['email'];

              return '<span class="user-email">' + $email + '</span>';
            }
          },{
            // User email
            targets: 4,
            render: function (data, type, full, meta) {
              var $email = full['role'];

              return '<span class="user-email">' + $email + '</span>';
            }
          },
          {
            // email verify
            targets: 5,
            className: 'text-center',
            render: function (data, type, full, meta) {
              var $verified = full['email_verified_at'];
              return `${
                $verified
                  ? '<i class="ti fs-4 ti-shield-check text-success"></i>'
                  : '<i class="ti fs-4 ti-shield-x text-danger" ></i>'
              }`;
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
                `<button class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="ti ti-edit"></i></button>` +
                `<button class="btn btn-sm btn-icon delete-record" data-id="${full['id']}"><i class="ti ti-trash"></i></button>` +
                '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                '<a href="' +
                userView +
                '" class="dropdown-item">View</a>' +
                '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
                '</div>' +
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
                title: 'Users',
                text: '<i class="ti ti-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3],
                  // prevent avatar to be print
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
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
                extend: 'csv',
                title: 'Users',
                text: '<i class="ti ti-file-text me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3],
                  // prevent avatar to be print
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList.contains('user-name')) {
                          result = result + item.lastChild.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              },
              {
                extend: 'excel',
                title: 'Users',
                text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList.contains('user-name')) {
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
                title: 'Users',
                text: '<i class="ti ti-file-text me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [2, 3],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList.contains('user-name')) {
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
                title: 'Users',
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
                        if (item.classList.contains('user-name')) {
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
            text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New User</span>',
            className: 'add-new btn btn-primary',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddUser'
            }
          }
        ],
        // For responsive popup
        // responsive: {
        //   details: {
        //     display: $.fn.dataTable.Responsive.display.modal({
        //       header: function (row) {
        //         var data = row.data();
        //         return 'Details of ' + data['name'];
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
        // }
      });
    }

    // Delete Record
    $(document).on('click', '.delete-record', function () {
      var user_id = $(this).data('id'),
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
            url: `${baseUrl}user-list/${user_id}`,
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
            text: 'The user has been deleted!',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The User is not deleted!',
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
      var user_id = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');

      // hide responsive modal in small screen
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }

      // changing the title of offcanvas
      $('#offcanvasAddUserLabel').html('Edit User');

      // get data
      $.get(`${baseUrl}user-list\/${user_id}\/edit`, function (data) {
        $('#user_id').val(data.id);
        $('#add-user-fullname').val(data.name);
        $('#add-user-email').val(data.email);
        $('#add-user-contact').val(data.contact);
        $('#division').val(data.division_id).trigger('change');
        $('#position').val(data.position_id).trigger('change');
      });
    });

    // changing the title
    $('.add-new').on('click', function () {
      $('#user_id').val(''); //reseting input field
      $('#offcanvasAddUserLabel').html('Add User');
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);

    // validating form and updating user's data
    const addNewUserForm = document.getElementById('addNewUserForm');

    // user form validation
    const fv = FormValidation.formValidation(addNewUserForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter fullname'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        },
        userContact: {
          validators: {
            notEmpty: {
              message: 'Please enter your contact'
            }
          }
        },
        division: {
          validators: {
            notEmpty: {
              message: 'Please select division from the list'
            }
          }
        },
        position: {
          validators: {
            notEmpty: {
              message: 'Please select position from the list'
            }
          }
        },
        company: {
          validators: {
            notEmpty: {
              message: 'Please enter your company'
            }
          }
        }
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
        data: $('#addNewUserForm').serialize(),
        url: `${baseUrl}user-list`,
        type: 'POST',
        success: function (status) {
          dt_user.draw();
          offCanvasForm.offcanvas('hide');

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status}!`,
            text: `User ${status} Successfully.`,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (err) {
          offCanvasForm.offcanvas('hide');
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'Your email should be unique.',
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
      fv.resetForm(true);
    });

    const phoneMaskList = document.querySelectorAll('.phone-mask');

    // Phone Number
    if (phoneMaskList) {
      phoneMaskList.forEach(function (phoneMask) {
        new Cleave(phoneMask, {
          phone: true,
          phoneRegionCode: 'MY'
        });
      });
    }
  });

</script>
@endsection

@section('content')

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$totalUser}}</h3>
{{--              <small class="text-success">(100%)</small>--}}
            </div>
            <small>Total Users</small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Verified Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$verified}}</h3>
{{--              <small class="text-success">(+95%)</small>--}}
            </div>
            <small>Recent analytics </small>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class="ti ti-user-check ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Duplicate Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$userDuplicates}}</h3>
{{--              <small class="text-success">(0%)</small>--}}
            </div>
            <small>Recent analytics</small>
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class="ti ti-users ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Verification Pending</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$notVerified}}</h3>
{{--              <small class="text-danger">(+6%)</small>--}}
            </div>
            <small>Recent analytics</small>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class="ti ti-user-circle ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Users List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Search Filter</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th>Id</th>
          <th>User</th>
          <th>Email</th>
          <th>Position</th>
          <th>Verified</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id" id="user_id">
        <div class="mb-3">
          <label class="form-label" for="add-user-fullname">Full Name</label>
          <input type="text" class="form-control" id="add-user-fullname" placeholder="Prefer Name" name="name" aria-label="" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-email">Email</label>
          <input type="text" id="add-user-email" class="form-control" placeholder="Email address" aria-label="" name="email" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-contact">Contact</label>
          <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="012 3456789" aria-label="" name="userContact" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-company">Division</label>
          <select id="division" name="division" class="form-select">
            <option value="">Select</option>
            @foreach($divisions as $division)
              <option value="{{$division->id}}">{{$division->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="country">Position</label>
          <select id="position" name="position" class="form-select">
            <option value="">Select</option>
            @foreach($positions as $position)
              <option value="{{$position->id}}">{{$position->name}}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection
