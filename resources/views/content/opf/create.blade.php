@extends('layouts/layoutMaster')

@section('title', 'OPF Forms - Create')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
{{--  <script src="{{asset('assets/vendor/libs/jquery-sticky/jquery-sticky.js')}}"></script>--}}
  <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

  <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>

  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
  <script src="{{asset('assets/vendor/libs/autosize/autosize.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/opf-file.js')}}"></script>
  <script>



    const display_options = {
      style: 'decimal',  // Other options: 'currency', 'percent', etc.
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    };


    const   billingaddres=jQuery(formOPF.querySelector('[name="formbillingaddress"]')),
    deliveryaddress =jQuery(formOPF.querySelector('[name="formAddress"]'));



    if (billingaddres) {
      autosize(billingaddres);
    }
    if (deliveryaddress) {
      autosize(deliveryaddress);
    }




    function fn60sec() {

      var id = $("[name='opf_id").val();

      var formCustomer = $("[name='formCustomer").val();
      var formPIC = $("[name='formPIC").val();
      var formPIC = $("[name='formPIC").val();
      if(id.length != 0 &&formCustomer.length!=0&&formPIC.length!=0&&formCustomer.length!=0)
      {
        const toastAnimationExample = document.querySelector('.toast-ex');
        let selectedType, selectedAnimation, selectedPlacement, toast, toastAnimation, toastPlacement;
        selectedType = 'text-danger';
        selectedAnimation = 'animate__pulse';
        toastAnimationExample.classList.add(selectedAnimation);
        toastAnimationExample.querySelector('.ti').classList.add(selectedType);
        toastAnimation = new bootstrap.Toast(toastAnimationExample);


        $.ajax({
        //  data: $('#formOPF').serialize(),
          data: $('#formOPF').serialize(),
          url: `${baseUrl}app/opf/create`,
          type: 'POST',

          success: function (status) {

            $('#opf_id').val(status['id']);
            $('#opfid').val(status['id']);
            $('#footer_opf').load(document.URL +  ' #footer_opf');
            // sweetalert
            // $('#tbody').load(document.URL +  ' #tbody');

            toastAnimation.show();
          },
          error: function (err) {

            //  offCanvasForm.offcanvas('hide');

          }
        });
      }

    }
    setInterval(fn60sec, 30*1000);

    document.addEventListener('DOMContentLoaded', function (e) {
      (function () {

        // var topSpacing;
        // const stickyEl = $('.sticky-element');
        //
        // // Init custom option check
        // window.Helpers.initCustomOptionCheck();
        //
        // // Set topSpacing if the navbar is fixed
        // if (Helpers.isNavbarFixed()) {
        //   topSpacing = $('.layout-navbar').height() + 7;
        // } else {
        //   topSpacing = 0;
        // }
        //
        // // sticky element init (Sticky Layout)
        // if (stickyEl.length) {
        //   stickyEl.sticky({
        //     topSpacing: topSpacing,
        //     zIndex: 9
        //   });
        // }

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        const formOPF = document.getElementById('formOPF'),
          formCustomerEle = jQuery(formOPF.querySelector('[name="formCustomer"]')),
          formCurrency = jQuery(formOPF.querySelector('[name="formCurrency"]')),

          formPICEle = jQuery(formOPF.querySelector('[name="formPIC"]')),
          formPICCom = jQuery(formOPF.querySelector('[name="company"]')),
          formSalesPerson = jQuery(formOPF.querySelector('[name="formSalesPerson"]')),
          formValidationTechEle = jQuery(formOPF.querySelector('[name="formValidationTech"]')),
          tech = [
            'ReactJS',
            'Angular',
            'VueJS',
            'Html',
            'Css',
            'Sass',
            'Pug',
            'Gulp',
            'Php',
            'Laravel',
            'Python',
            'Bootstrap',
            'Material Design',
            'NodeJS'
          ];

        const fv = FormValidation.formValidation(formOPF, {
          fields: {

            formAddress: {
              validators: {
                notEmpty: {
                  message: 'Delivery Address Required'
                }
              }
            },
            formbillingaddress: {
              validators: {
                notEmpty: {
                  message: 'Billing Address Required'
                }
              }
            },
            formValidationFile: {
              validators: {
                notEmpty: {
                  message: 'Please select the file'
                }
              }
            },
            formPoNumber: {
              validators: {
                notEmpty: {
                  message: 'PO Number required'
                }
              }
            },
            formDueDate: {
              validators: {
                notEmpty: {
                  message: 'Please select Due Date'
                },
                date: {
                  format: 'YYYY/MM/DD',
                  message: 'The value is not a valid date'
                }
              }
            },
            formCustomer: {
              validators: {
                notEmpty: {
                  message: 'Please select customer from the list'
                }
              }
            },
            formSalesPerson: {
              validators: {
                notEmpty: {
                  message: 'Please select Sales Person from the list'
                }
              }
            },
            formPIC: {
              validators: {
                notEmpty: {
                  message: 'Please select Person in Charge from the list'
                }
              }
            },
            formNotes: {
              validators: {
                notEmpty: {
                  message: 'Note is Required'
                }
                // ,
                // stringLength: {
                //   min: 100,
                //   max: 500,
                //   message: 'The bio must be more than 100 and less than 500 characters long'
                // }
              }
            },
          },
          plugins: {

            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
              // Use this for enabling/changing valid/invalid class
              // eleInvalidClass: '',
              eleValidClass: '',
              rowSelector: function (field, ele) {
                // field is the field name & ele is the field element
                switch (field) {
                  case 'formAddress':
                  case 'formValidationFile':
                  case 'formDueDate':
                  case 'formCustomer':
                  case 'formPIC':
                  case 'formValidationHobbies':
                  case 'formNotes':
                  case 'formSalesPerson':
                  case 'formValidationCheckbox':
                    return '.col-12';
                  default:
                    return '.row';
                }
              }
            }),
            submitButton: new FormValidation.plugins.SubmitButton(

            ),
            // Submit the form when all fields are valid
           // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()
          },
          init: instance => {
            instance.on('plugins.message.placed', function (e) {
              //* Move the error message out of the `input-group` element
              if (e.element.parentElement.classList.contains('input-group')) {
                // `e.field`: The field name
                // `e.messageElement`: The message element
                // `e.element`: The field element
                e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
              }
              //* Move the error message out of the `row` element for custom-options
              if (e.element.parentElement.parentElement.classList.contains('custom-option')) {
                e.element.closest('.row').insertAdjacentElement('afterend', e.messageElement);
              }
            });
          }

        }).on('core.form.valid', function () {
        //  var form = $('#formOPF')[0];
      //    var formData = new FormData(form);
        //  console.log(formData);
          $.ajax({
            data: $('#formOPF').serialize(),
            // processData: false,
            // contentType: false,
            url: `${baseUrl}app/opf/create`,
            type: 'POST',

            success: function (status) {

              $('#opf_id').val(status['id']);



              $('#opfid').val(status['id']);
              $('#footer_opf').load(document.URL +  ' #footer_opf');
              // sweetalert
              $('#footer_opf').load(document.URL +  ' #footer_opf');
              Swal.fire({
                icon: 'success',
                title: `Successfully ${status['message']}!`,
                text: `OPF ${status['message']} Successfully.`,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              }).then(function() {
                if(status['set_redirect']){
                  $(window).unbind('beforeunload');
                  window.location = "form/"+status['id'];
                }

              });
            },
            error: function (err) {

             //  offCanvasForm.offcanvas('hide');
              Swal.fire({
                title: 'Duplicate Entry!',
                text: 'Path Number should be unique.',
                icon: 'error',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
          });

        });

        //? Revalidation third-party libs inputs on change trigger

        // Flatpickr
        flatpickr(formOPF.querySelector('[name="formDueDate"]'), {
          enableTime: false,
          defaultDate: "today",
          // See https://flatpickr.js.org/formatting/
          dateFormat: 'Y/m/d',
          // After selecting a date, we need to revalidate the field
          onChange: function () {
            fv.revalidateField('formDueDate');
          }
        });

        // Select2 (Country)
        if (formCustomerEle.length) {
          formCustomerEle.wrap('<div class="position-relative"></div>');
          formCustomerEle
            .select2({
              placeholder: 'Select Customer',
              dropdownParent: formCustomerEle.parent(),
              language: {
                noResults: function () {
                   return $("<a href='#' data-bs-toggle='offcanvas' data-bs-target='#offcanvasAddCompany'>Create Customer</a>");
                  //  return $("<a href='#' onclick='demo()'>Create Customer</a>");
                }
              }
            })
            .on('change.select2', function () {
              // Revalidate the color field when an option is chosen
              fv.revalidateField('formCustomer');
            });
        }

        if (formCurrency.length) {
          formCurrency.wrap('<div class="position-relative"></div>');
          formCurrency
            .select2({
              placeholder: 'Select Currenct',
              dropdownParent: formCurrency.parent(),
            })
            .on('change.select2', function () {
              // Revalidate the color field when an option is chosen
              fv.revalidateField('formCustomer');
            });
        }




        if (formPICCom.length) {
          formPICCom.wrap('<div class="position-relative"></div>');
          formPICCom
            .select2({
              placeholder: 'Select Person In Charge',
              dropdownParent: formPICCom.parent(),
            })
            .on('change.select2', function () {
              // Revalidate the color field when an option is chosen
              fv.revalidateField('formPIC');
            });
        }


        if (formPICEle.length) {
          formPICEle.wrap('<div class="position-relative"></div>');
          formPICEle
            .select2({
              placeholder: 'Select Person In Charge',
              dropdownParent: formPICEle.parent(),
              language: {
                noResults: function () {
                  return $("<a href='#' data-bs-toggle='offcanvas' data-bs-target='#offcanvasAddPIC'>Create Person In Charge</a>");
                  //  return $("<a href='#' onclick='demo()'>Create Customer</a>");
                }
              }
            })
            .on('change.select2', function () {
              // Revalidate the color field when an option is chosen
              fv.revalidateField('formPIC');
            });
        }

        // if (formSalesPerson.length) {
        //   formSalesPerson.wrap('<div class="position-relative"></div>');
        //   formSalesPerson
        //     .select2({
        //       placeholder: 'Select Person In Charge',
        //       dropdownParent: formSalesPerson.parent()
        //     })
        //     .on('change.select2', function () {
        //       // Revalidate the color field when an option is chosen
        //       fv.revalidateField('formSalesPerson');
        //     });
        // }


        // Typeahead

        // String Matcher function for typeahead
        const substringMatcher = function (strs) {
          return function findMatches(q, cb) {
            var matches, substrRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
            $.each(strs, function (i, str) {
              if (substrRegex.test(str)) {
                matches.push(str);
              }
            });

            cb(matches);
          };
        };

        // Check if rtl
        if (isRtl) {
          const typeaheadList = [].slice.call(document.querySelectorAll('.typeahead'));

          // Flat pickr
          if (typeaheadList) {
            typeaheadList.forEach(typeahead => {
              typeahead.setAttribute('dir', 'rtl');
            });
          }
        }
        formValidationTechEle.typeahead(
          {
            hint: !isRtl,
            highlight: true,
            minLength: 1
          },
          {
            name: 'tech',
            source: substringMatcher(tech)
          }
        );


      })();
    });




    $(document).on('change', '.select-customer', function() {
      var value = $(this).val();
      $.ajax({
        type: 'GET',
        url: "{{route('getCompany')}}",
        data: {'value': value},

        success: function (response) {

          $('#formAddress').val(response.address_1);
          $('#formbillingaddress').val(response.billing_address);
          $('#formCurrency').val(response.currency).change();
          $('#formCurrencyRate').val(response.currency_rate);


        }
      });
    });

    const  formSelectAddressBook = jQuery(document.querySelector('[name="companyaddressdescription"]'));
    if (formSelectAddressBook.length) {
      formSelectAddressBook.wrap('<div class="position-relative"></div>');
      formSelectAddressBook
        .select2({
          placeholder: 'Select Address Description',
          dropdownParent: formSelectAddressBook.parent(),
        })
        .on('change.select2', function () {
          // Revalidate the color field when an option is chosen
          //fv.revalidateField('formCustomer');
        });
    }
//TODO single file upload
    $(document).on('change', '.check_upload_file', function() {
      console.log($(this).files[0].name);

    });

    $(document).on('click', '.submit-opf', function() {
      var id = $(this).data('id');
    //  console.log('submit button -'+id);

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Submit it!',
        customClass: {
          confirmButton: 'btn btn-primary me-3',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          $.ajax({

            type: "POST",
            url: "/app/opf/submit",
            data: {id: id},
            dataType: 'json',
            success: function () {
              // $('#tbody').load(document.URL + ' #tbody tr');
              // $('#footer_opf').load(document.URL + ' #footer_opf');
            },
            error: function (error) {
              //console.log(error);
            }
          });

          // success sweetalert
          Swal.fire({
            icon: 'success',
            title: 'Submitted!!',
            text: 'The OPF has been Submitted!',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The action been cancel!',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });

    });
    $(document).on('click', '.address-book', function() {
      var value = $("[name='formCustomer']").val()
      $("[name='companyaddressdescription']").empty();
      $.ajax({
        type: 'GET',
        url: "{{route('getCustomerAddressBook')}}",
        data: {'value': value},

        success: function (response) {



          response.forEach(function(response) {
            var data = {
              id: response['id'],
              text: response['text']
            };
            var newOption = new Option(data.text, data.id, false, false);

            $("[name='companyaddressdescription']").append(newOption);
          });
          $("[name='companyaddressdescription']").trigger('change');


        }
      });
    });

    $(document).on('change', '.select-currency', function() {
      var value = $(this).val();
      $.ajax({
        type: 'GET',
        url: "{{route('getCurrencyRate')}}",
        data: {'value': value},

        success: function (response) {
          $('#formCurrencyRate').val(response.rate);


        }
      });
    });

    $(document).on('change', '.select-pic', function() {
      var value = $(this).val();
      $.ajax({
        type: 'GET',
        url: "{{route('getPic')}}",
        data: {'value': value},

        success: function (response) {
          $('#picContact').val(response.contact);
          $('#picEmail').val(response.email);
          $('#formCurrencyRate').val(response.currency_rate);


        }
      });
    });

    $(document).on('change', '.select-sales-person', function() {
      var value = $(this).val();
      $.ajax({
        type: 'GET',
        url: "{{route('getSalesPerson')}}",
        data: {'value': value},

        success: function (response) {


          $('#formDivision').val(response[0].division_name);


        }
      });
    });


    $('.job_repeater').repeater({
      show: function () {
        $(this).slideDown();

       // $('.select2-container').remove();
        $(' .select2-part-number').select2({
          placeholder: "Select the Supplier",
          allowClear: true
        });
        $('.select2-container').css('width','100%');


        const part_comment = document.querySelector('.part-comment');

        if (part_comment) {
          autosize(part_comment);
        }

      },
      hide: function (remove) {
        if (confirm('Are you sure you want to delete this element?')) {
          $(this).slideUp(remove);
          $("[name='submitButton").click();

        }
      }
    });


    const addPICRecordForm = document.getElementById('addPICRecordForm');
    var offCanvasPICForm = $('#offcanvasAddPIC');
    const fv = FormValidation.formValidation(addPICRecordForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter PIC name'
            }
          }
        },
        contact: {
          validators: {
            notEmpty: {
              message: 'Contact is required'
            },
            stringLength: {
              min: 9,
              max: 11,
              message: 'Contact required at least 9 digit, Max 11 digit '
            },
            regexp: {
              regexp: /^[0-9\-]+$/,
              message: 'Numeric only, e.g 012-3456789'
            }
          }
        },
        company: {
          validators: {
            notEmpty: {
              message: 'Select Company from the list'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: 'Address is required'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
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
        data: $('#addPICRecordForm').serialize(),
        url: `${baseUrl}pic-list`,
        type: 'POST',
        success: function (status) {

          offCanvasPICForm.offcanvas('hide');
          var data = {
            id: status['id'],
            text: status['name']
          };
          var newOption = new Option(data.text, data.id, false, false);
          $('#formPIC').append(newOption).trigger('change');

          $('#formPIC').val(status['id']);
          $('#formPIC').trigger('change');
          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status['message']}!`,
            text: `PIC ${status['message']} Successfully.`,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (err) {
            offCanvasPICForm.offcanvas('hide');
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'PIC should be unique.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    // clearing form data when offcanvas hidden
    offCanvasPICForm.on('hidden.bs.offcanvas', function () {
      fv.resetForm(true);
    });
    ////End PIC

//Customer
    $(document).on('change', '.search-currency', function() {
      var selectedValue = $(this).val();
      $.ajax({
        type: 'GET',
        url: "{{route('getCurrencyRate')}}",
        data: {'value': selectedValue},

        success: function (response) {
          $('#currency_rate').val(response.rate);

        }
      });
    });
    const offCanvasAddressBookForm = $('#offcanvasSelectAddress');
    $(document).on('click', '.data-submit-addressbook', function() {

       $('#formbillingaddress').val($('#address_book_billing_address').text());
       $('#formAddress').val($('#address_book_delivery_address').text());
      offCanvasAddressBookForm.offcanvas('hide');

    });
    $(document).on('change', '.search-addressbook', function() {
      var selectedValue = $(this).val();

      $.ajax({
        type: 'GET',
        url: "{{route('getAddressBookInfo')}}",
        data: {'value': selectedValue},

        success: function (response) {
          $('#address_book_billing_address').text(response.billing_address);
          $('#address_book_delivery_address').text(response.delivery_address);

        }
      });
    });
    const addNewCompanyForm = document.getElementById('addNewCompanyForm');

   var offCanvasForm = $('#offcanvasAddCompany');

    // user form validation
    const CompanyFormValidation = FormValidation.formValidation(addNewCompanyForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter company name'
            }
          }
        },
        address_1: {
          validators: {
            notEmpty: {
              message: 'Address is required'
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
        data: $('#addNewCompanyForm').serialize(),
        url: `${baseUrl}company-list`,
        type: 'POST',
        success: function (status) {
          var data = {
            id: status['id'],
            text: status['name']
          };
          var newOption = new Option(data.text, data.id, false, false);
          $('#formCustomer').append(newOption).trigger('change');
          $('#formCustomer').val(status['id']);
          $('#formCustomer').trigger('change');

          var newOption1 = new Option(data.text, data.id, false, false);
          $('#_company').append(newOption1).trigger('change');
          $('#_company').trigger('change');

          offCanvasForm.offcanvas('hide');

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status['message']}!`,
            text: `Company ${status['message']} Successfully.`,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (err) {
          offCanvasForm.offcanvas('hide');
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'Company should be unique.',
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
      CompanyFormValidation.resetForm(true);
    });



    ///Customer

    $(function () {

      var applyChangesBtn = $('.btn-apply-changes'),
        discount,
        tax1,
        tax2,
        discountInput,
        tax1Input,
        tax2Input,
        sourceItem = $('.source-item');


      // Prevent dropdown from closing on tax change
      $(document).on('click', '.tax-select', function (e) {
        e.stopPropagation();
      });

      // On tax change update it's value value
      function updateValue(listener, el) {

        listener.closest('.repeater-wrapper').find(el).text(listener.val());
      }

      // Apply item changes btn
      if (applyChangesBtn.length) {
        $(document).on('click', '.btn-apply-changes', function (e) {
          var $this = $(this);
          tax1Input = $this.closest('.dropdown-menu').find('#taxInput1');
          tax2Input = $this.closest('.dropdown-menu').find('#formInputcurrency');
          discountInput = $this.closest('.dropdown-menu').find('#taxInput3');;
          tax1 = $this.closest('.repeater-wrapper').find('.tax-1');
          tax2 = $this.closest('.repeater-wrapper').find('.tax-2');
          discount = $('.discount');

          if (tax1Input.val() !== null) {
            updateValue(tax1Input, tax1);
          }

          if (tax2Input.val() !== null) {
            updateValue(tax2Input, tax2);
          }

          if (discountInput.val() !== null) {
            $this
              .closest('.repeater-wrapper')
              .find(discount)
              .text(discountInput.val() + '%');
          }
        });
      }

      // Repeater init
      if (sourceItem.length) {
        sourceItem.on('submit', function (e) {
          e.preventDefault();
        });
        sourceItem.repeater({
           initEmpty: true,
          show: function () {
            $('.select2-part-number').select2({
              placeholder: "Select the Supplier",
              allowClear: true
            });
            $('.select2-supplier').select2({
              placeholder: "Select the Supplier",
              allowClear: true
            });
            $('.select2-container').css('width','100%');
         //   console.log($(this).data());
            $(this).slideDown();
            // Initialize tooltip on load of each item
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            const part_comment = document.querySelector('.part-comment');

            if (part_comment) {
              autosize(part_comment);
            }

            },







        hide: function (e) {
            if (confirm('Are you sure you want to delete this element?')) {
              $(this).slideUp(e);

              setTimeout(function(){
                $("[name='submitButton").click()
              },1000);
              //

            }
          }
        });
      }


      $(document).on('change', '.supplier-details', function () {
        var value = $(this).val();
        let str = $(this).attr("name")
        {{--var $_form_id = str.split('opfitem[').pop().split('][')[0];--}}
        {{--$("[name='opfitem["+$_form_id+"][form_part_number]']").empty();--}}
        {{--$.ajax({--}}
        {{--  type: 'GET',--}}
        {{--  url: "{{route('getSupplierItem')}}",--}}
        {{--  data: {'value': value},--}}

        {{--  success: function (response) {--}}

        {{--    response.forEach(function(response) {--}}
        {{--      var data = {--}}
        {{--        id: response['id'],--}}
        {{--        text: response['text']--}}
        {{--      };--}}
        {{--      var newOption = new Option(data.text, data.id, false, false);--}}

        {{--      $("[name='opfitem["+$_form_id+"][form_part_number]']").append(newOption);--}}
        {{--    });--}}
        {{--    $("[name='opfitem["+$_form_id+"][form_part_number]']").trigger('change');--}}


        {{--  }--}}
        {{--});--}}

      });

      $(document).on('change', '.item-calculation', function () {

        var $_form_id=$(this).attr("name").split('opfitem[').pop().split('][')[0];


        let $_form_qty= $("[name='opfitem["+$_form_id+"][form_qty]']").val() ?? 0;
        let $_form_unit_selling_price= $("[name='opfitem["+$_form_id+"][form_unit_selling_price]']").val() ?? 0;
        let $_freight= $("[name='opfitem["+$_form_id+"][form_freight]']").val()/100 ?? 0;
        let $_unit_cost= $("[name='opfitem["+$_form_id+"][form_unit_cost]']").val() ?? 0;
        let $_currency= $("[name='opfitem["+$_form_id+"][formInputcurrency]']").val() ?? 1;
        let $_taxduty= $("[name='opfitem["+$_form_id+"][form_taxes]']").val()/100 ?? 0;


        let $_cal_freight=$_freight*($_currency*$_unit_cost);
        let $_cal_tax=$_taxduty*($_currency*$_unit_cost);
        let $_cal_unit_landed_cost=$_cal_freight+$_cal_tax+($_currency*$_unit_cost);
        let $_cal_total_unit_landed_cost=$_cal_unit_landed_cost*$_form_qty;
        let $total_selling_price=($_form_qty*$_form_unit_selling_price);
        let $_cal_margin=(($total_selling_price-$_cal_total_unit_landed_cost)/$total_selling_price)*100;
        let $_cal_profit=$total_selling_price-$_cal_total_unit_landed_cost;



        $("[name='opfitem["+$_form_id+"][form_part_total_selling_price]']").val($total_selling_price.toFixed(2)),
        $("[name='opfitem["+$_form_id+"][form_total_cost]']").val($_cal_total_unit_landed_cost.toFixed(2))
        $("[name='opfitem["+$_form_id+"][freight_cost]']").text($_cal_freight.toLocaleString('en-US',display_options))
        $("[name='opfitem["+$_form_id+"][total_freight_cost]']").val(($_cal_freight*$_form_qty).toFixed(2))
        $("[name='opfitem["+$_form_id+"][form_freight_cost]']").val($_cal_freight.toFixed(2))
        $("[name='opfitem["+$_form_id+"][taxduty_cost]']").text($_cal_tax.toLocaleString('en-US',display_options))
        $("[name='opfitem["+$_form_id+"][total_taxduty_cost]']").val(($_cal_tax*$_form_qty).toFixed(2))
        $("[name='opfitem["+$_form_id+"][form_taxduty_cost]']").val($_cal_tax.toFixed(2))
        $("[name='opfitem["+$_form_id+"][unit_landed_cost]']").text($_cal_unit_landed_cost.toLocaleString('en-US',display_options))
        $("[name='opfitem["+$_form_id+"][form_unit_landed_cost]']").val($_cal_unit_landed_cost.toFixed(2))
        $("[name='opfitem["+$_form_id+"][text_currency]']").text($_currency)
        $("[name='opfitem["+$_form_id+"][form_item_margin]']").val($_cal_margin.toFixed(2))
        $("[name='opfitem["+$_form_id+"][unit_item_profit]']").text($_cal_profit.toLocaleString('en-US',display_options))
        $("[name='opfitem["+$_form_id+"][form_unit_item_profit]']").val($_cal_profit.toFixed(2))

        if($_cal_margin>=0)
        {
          $("[name='opfitem["+$_form_id+"][form_item_margin]']").removeClass('text-danger').addClass('text-success')
        }else{
          $("[name='opfitem["+$_form_id+"][form_item_margin]']").removeClass('text-success bg-success').addClass('text-danger')
        }

        if($_cal_profit>=0)
        {
          $("[name='opfitem["+$_form_id+"][unit_item_profit]']").removeClass('text-danger').addClass('text-success')
        }else{
          $("[name='opfitem["+$_form_id+"][unit_item_profit]']").removeClass('text-success bg-success').addClass('text-danger')
        }

        update_total();










        // tax2 = $this.closest('.repeater-wrapper').find('.tax-2');


       // $("[name='opfitem["+$_form_id+"][form_part_desc]']").val();
       // form_calculation($_form_qty*$_form_unit_selling_price);



      });

      // Item details select onchange
      $(document).on('change', '.item-details', function () {
        var value = $(this).val();
        let str = $(this).attr("name")
        var $_form_id = str.split('opfitem[').pop().split('][')[0];
        $.ajax({
          type: 'GET',
          url: "{{route('getItemInv')}}",
          data: {'value': value},

          success: function (response) {
            var varName = $('input[name="opfitem['+$_form_id+'][part_item_poison][]"]:checked').val();
            if(varName=='on'){
              $("[name='opfitem["+$_form_id+"][part_item_poison][]']").click();
            }

            $newvalue='#opfitem['+$_form_id+'][form_part_desc]';
            //document.getElementsByName($newvalue)[0].value=;
            $("[name='opfitem["+$_form_id+"][form_part_desc]']").val(response.name);
           // $("[name='opfitem["+$_form_id+"][form_unit_cost]']").val(response.base_rate);
            $("[name='opfitem["+$_form_id+"][formInputcurrency]']").val(response.currency_rate);

            if(response.is_poison==1){
                $("[name='opfitem["+$_form_id+"][part_item_poison][]']").click();
            }

            // $('#picEmail').val(response.email);
            // $('#formCurrencyRate').val(response.currency_rate);


          }
        });

      });
    });

    $(window).bind('beforeunload', function(){
      return 'Are you sure you want to leave?';
    });

    $(function(){
      // Landing
      var id = $("[name='opf_id").val();
      if(id==0){
        $("[name='opf_id").val(null);
      }
      $.ajax({
        type: "GET",
        url: "{{ route('getOpfItem') }}",
        data: {id: id},
        dataType: 'json',
        success: function (res) {


          let num=0;
        //  $('[data-repeater-list]').empty();
          res.forEach((record) => {
            $('.opf_item').find('[data-repeater-create]').click();
            $("[name='opfitem["+num+"][form_supplier]']").val(record.supplier_id).select2();
            $("[name='opfitem["+num+"][form_part_number]']").val(record.part_id).select2();

            $("[name='opfitem["+num+"][form_part_desc]']").val(record.part_name);

            $("[name='opfitem["+num+"][form_unit_cost]']").val(record.unit_cost);
            $("[name='opfitem["+num+"][form_qty]']").val(record.qty);
            $("[name='opfitem["+num+"][form_freight]']").val(record.freight);
            $("[name='opfitem["+num+"][form_unit_selling_price]']").val(record.unit_selling_price);
            $("[name='opfitem["+num+"][form_taxes]']").val(record.taxes);
            $("[name='opfitem["+num+"][form_part_total_selling_price]']").val(record.total_selling_price);
            $("[name='opfitem["+num+"][form_total_cost]']").val(record.total_cost);
            $("[name='opfitem["+num+"][formInputcurrency]']").val(record.currency).trigger('change');
            $("[name='opfitem["+num+"][form_po_no]']").val(record.po_number).trigger('change');
            $("[name='opfitem["+num+"][form_gr_no]']").val(record.gr_number).trigger('change');
            $("[name='opfitem["+num+"][form_delivery_no]']").val(record.do_number).trigger('change');
            $("[name='opfitem["+num+"][form_invoice_no]']").val(record.invoice_number).trigger('change');
            $("[name='opfitem["+num+"][formInputcurrency]']").val(record.currency).trigger('change');
            $("[name='opfitem["+num+"][part_item_note]']").val(record.part_comment);

            if(record.is_poison==1){
              $("[name='opfitem["+num+"][part_item_poison][]']").click();
            }

            if(record.gr_check==1){
              $("[name='opfitem["+num+"][form_gr_check][]']").click();
            }
            if(record.po_check==1){
              $("[name='opfitem["+num+"][form_po_check][]']").click();
            }
            if(record.stock_check==1){
              $("[name='opfitem["+num+"][formItemStock][]']").click();
            }
            if(record.invoice_check==1){
              $("[name='opfitem["+num+"][form_invoice_check][]']").click();
            }
            if(record.do_check==1){
              $("[name='opfitem["+num+"][form_delivery_check][]']").click();
            }






            num++;

          });



        }
      })
    });


    function display_output($a){
      return $a.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }
    function update_total(){

      var sum_tax = 0;
      var sum_total_cost_of_goods=0;
      var sum_total_selling_price=0;
      var sum_shipping_charge=0;
      var sum_gross_profit=0;
      var sum_gross_profit_percent=0;

      $('.total-taxduty-cost ').each(function(){
        sum_tax += parseFloat($(this).val());
      });

      $('.total-selling-price').each(function(){
        sum_total_selling_price += parseFloat($(this).val());
      });

      $('.total-freight-cost').each(function(){
        sum_shipping_charge += parseFloat($(this).val());
      });

      $('.item-total-cost').each(function(){
        sum_total_cost_of_goods += parseFloat($(this).val());
      });

      $('.unit-item-profit').each(function(){
        sum_gross_profit += parseFloat($(this).text());
      });

      sum_gross_profit_percent=((sum_total_selling_price-sum_total_cost_of_goods)/sum_total_selling_price)*100;

      $("[name='sum_total_po_value']").text("RM "+sum_total_selling_price.toLocaleString('en-US',display_options));
      $("[name='field_sum_total_po_value']").val(sum_total_selling_price.toFixed(2));
      $("[name='sum_total_cost_of_goods']").text("RM "+sum_total_cost_of_goods.toLocaleString('en-US',display_options));
      $("[name='field_sum_total_cost_of_goods']").val(sum_total_cost_of_goods.toFixed(2));
      $("[name='sum_total_tax']").text("RM "+sum_tax.toLocaleString('en-US',display_options));
      $("[name='field_sum_total_tax']").val(sum_tax.toFixed(2));
      $("[name='sum_total_shipping']").text("RM "+sum_shipping_charge.toLocaleString('en-US',display_options));
      $("[name='field_sum_total_shipping']").val(sum_shipping_charge.toFixed(2));
      $("[name='sum_total_gross_profit']").text("RM "+sum_gross_profit.toLocaleString('en-US',display_options));
      $("[name='field_sum_total_gross_profit']").val(sum_gross_profit.toFixed(2));
      $("[name='sum_total_gross_profit_percent']").text(sum_gross_profit_percent.toLocaleString('en-US',display_options));
      $("[name='field_sum_total_gross_profit_percent']").val(sum_gross_profit_percent.toFixed(2));
    }

  </script>


@endsection

@section('content')

  @include('content/opf/_partial/add-company')
  @include('content/opf/_partial/addressbook')
  @include('content/opf/_partial/add-pic')



  <div class="row">
    <div class="col-12">
      <div class="col-xl-12">
        <div class="nav-align-top nav-tabs-shadow mb-4">
          <ul class="nav nav-tabs" role="tablist">


            <li class="nav-item">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true"><i class="tf-icons ti ti-home ti-xs me-1"></i>  OPF Form  @if($opf->exists) #{{$opf->id}}  - {{$opf->opf_status}}@endif</button>
            </li>
            <li class="nav-item">
              <a type="button"  href="{{route('app-opf-create-form')}}" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-opf-document" aria-controls="navs-top-opf-document" aria-selected="false"><i class="tf-icons ti ti-cloud-upload ti-xs me-1"></i> Documents</a>
            </li>
            <li class="nav-item">
              <a type="button"  href="{{route('opf.pdf.download',$opf->id)}}" class="nav-link" role="tab"><i class="tf-icons ti ti-cloud-download ti-xs me-1"></i> Download PDF</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">

{{--              <h5 class="card-header">OPF Form  @if($opf->exists) {{$opf->opf_no}} @endif</h5>--}}
              <div class="card-body">

                <div class="bs-toast toast toast-ex animate__animated my-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1000">
                  <div class="toast-header">
                    <i class="ti ti-bell ti-xs me-2"></i>
                    <div class="me-auto fw-medium">OPF Form</div>
                    <small class="text-muted">Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    Auto Saving...
                  </div>
                </div>

                <form id="formOPF"name="formOPF" class="source-item row g-3">
                  @csrf
                  <input type="hidden" value="@if($opf->exists){{$opf->id}}@endif" name="opf_id" id="opf_id">


                  {{--            <div class="col-12">--}}
                  {{--              <h6>Customer Details</h6>--}}
                  {{--              <hr class="mt-0" />--}}
                  {{--            </div>--}}

                  <div class="col-md-6">
                    <label class="form-label mb-1 d-flex justify-content-between align-items-center" for="formCustomer">
                      <span>Customer</span><a href='#' data-bs-toggle='offcanvas' data-bs-target='#offcanvasAddCompany'>Add New Customer</a>
                    </label>
                    <select id="formCustomer" name="formCustomer" class="form-select select2 select-customer" data-allow-clear="true" >
                      <option value="">Select Customer</option>
                      @foreach($customers as $value)

                        <option value="{{$value->id}}" @if($opf->exists &&$opf->customer_id==$value->id)
                          selected
                          @endif>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="formCurrency">Currency</label>

                    <select id="formCurrency" name="formCurrency" class="form-select select2 select-currency" data-allow-clear="true" >
                      <option value="">Select Currency</option>
                      @foreach($cRates as $value)
                        <option value="{{$value->name}}"
                                @if($opf->exists &&$opf->currency==$value->name)
                                  selected
                          @endif
                        >{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label" for="formCurrencyRate">Rate</label>
                    <input class="form-control" @if($opf->exists)
                      value="{{$opf->currency_rate}}"
                           @endif type="text" id="formCurrencyRate" name="formCurrencyRate" />
                  </div>


                  <div class="col-md-3">

                    <label class="form-label mb-1 d-flex justify-content-between align-items-center" for="formbillingaddress">
                      <span>Billing Address</span><a href='#' class='address-book' data-bs-toggle='offcanvas' data-bs-target='#offcanvasSelectAddress'>Address Book</a>
                    </label>

                    <textarea class="form-control"  placeholder="Billing Address" id="formbillingaddress" name="formbillingaddress" rows="3">@if($opf->exists){{$opf->customer_billing_address}}@endif</textarea>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label" for="formAddress">Delivery Address</label>
                    <textarea class="form-control"  placeholder="Delivery Address" id="formAddress" name="formAddress" rows="3">@if($opf->exists){{$opf->customer_delivery_address}}@endif</textarea>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="formStatus">Status</label>
                    <select id="formStatus" name="formStatus" class="form-select select2" data-allow-clear="true" >
                      <option selected value="open">Open</option>
                      <option @if($opf->exists && $opf->gr_status=='close')
                                selected
                              @endif value="close">Close</option>

                    </select>
                  </div>






                  <div class="col-md-6">

                    <label class="form-label mb-1 d-flex justify-content-between align-items-center" for="formPIC">
                      <span>Person In Charge</span><a href='#' data-bs-toggle='offcanvas' data-bs-target='#offcanvasAddPIC'>Add New Person In Charge</a>
                    </label>

                    <select id="formPIC" name="formPIC" class="form-select select2 select-pic" data-allow-clear="true">
                      <option value="">Select</option>

                      @foreach($pic as $_value)
                        <option @if($opf->exists &&$opf->pic_id==$_value->id)
                                  selected
                                @endif value="{{$_value->id}}">{{$_value->name}} - {{$_value->company_name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label" for="picContact">Contact</label>
                    <input type="text" class="form-control flatpickr-validation" value="@if($opf->exists){{$opf->contact}}@endif" placeholder="Contact" name="picContact" id="picContact" required />
                  </div>
                  <div class="col-md-3">
                    <label class="form-label" for="picEmail">Email</label>
                    <input type="text" class="form-control" name="picEmail" placeholder="Email Address" id="picEmail" value="@if($opf->exists){{$opf->pic_email}}@endif" required />
                  </div>


{{--                  <div class="col-md-6">--}}
{{--                    <label class="form-label" for="formSalesPerson">Sales Person</label>--}}
{{--                    <select id="formSalesPerson" name="formSalesPerson" readonly="true" class="form-select select2 select-sales-person" data-allow-clear="true">--}}
{{--                      <option value="">Select</option>--}}
{{--                      @foreach($allSalesPerson as $_value)--}}
{{--                        <option @if($opf->exists &&$opf->sales_person_id==$_value->id)--}}
{{--                                  selected--}}
{{--                                @elseif(($opf->id==0) && Auth::User()->id==$_value->id)--}}
{{--                                  selected--}}
{{--                                @endif value="{{$_value->id}}">{{$_value->name}}</option>--}}
{{--                      @endforeach--}}
{{--                    </select>--}}
{{--                  </div>--}}

                  <div class="col-md-6" style="display:none">
                    <label class="form-label " for="formSalesPersonid">Sales Person Id</label>
                    <input type="text" class="form-control " value="@if($opf->exists&&$opf->id==0){{Auth::User()->id}}@else{{$opf->sales_person_id}}@endif" readonly name="formSalesPersonid" id="formSalesPersonid" />
                  </div>

                  <div class="col-md-6">
                    <label class="form-label" for="formSalesPerson">Sales Person Name</label>
                    <input type="text" class="form-control" value="@if($opf->exists&&$opf->id==0){{Auth::User()->name}}@else{{$opf->sales_person}}@endif" readonly name="formSalesPerson" id="formSalesPerson" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="formDivision">Division</label>
                    <input type="text" class="form-control" value="@if($opf->exists&&$opf->id==0){{Auth::User()->division_name}}@else{{$opf->current_division}}@endif" readonly name="formDivision" id="formDivision" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="formPoNumber">PO Number #</label>
                    <input type="text" class="form-control" value="@if($opf->exists){{$opf->po_value}}@endif" name="formPoNumber" id="formPoNumber" required />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="formDueDate">Due Date</label>
                    <input type="text" class="form-control  flatpickr-validation" name="formDueDate" id="formDueDate" required />
                  </div>

                  {{--            <div class="col-md-6">--}}
                  {{--              <label class="form-label" for="formTagging">Tags</label>--}}
                  {{--              <input type="text" value="@if($opf->exists){{$opf->tags}}@endif" class="form-control" name="formTagging" id="formTagging" />--}}
                  {{--            </div>--}}



                  <div class="col-md-6">
                    <label class="form-label" for="formNotes">Note</label>
                    <textarea class="form-control" id="formNotes" value="testNotes" name="formNotes" rows="3">@if($opf->exists){{$opf->notes}}@endif</textarea>

                  </div>
                  <div class="col-12">
                    <hr class="mt-6" />
                  </div>






                  <div class="opf_item">
                    <div class="mb-3 " data-repeater-list="opfitem">


                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-repeater-add job_repeater" data-repeater-create>Add Item</button>
                      </div>

                      <div class="repeater-wrapper pt-0 pt-md-4 " data-repeater-item style="display:none;">
                        {{--                <div class="repeater-wrapper pt-0 pt-md-4 " data-repeater-item >--}}

                        <div class="d-flex border rounded position-relative pt-0">

                          <div class="row w-100 p-3">

                            <div class="col-lg-2 col-md-6 col-12 mb-md-0 mb-2 ">
                              <p class="mb-2 repeater-title ">Part Number</p>
                              <select class="form-select select2-part-number item-details mb-3" name="form_part_number" >
                                @foreach($iteminv as $item)
                                  <option value='{{$item->id}}'>{{$item->part_number}}</option>
                                @endforeach
                              </select>


                              <p class="mb-2 repeater-title mt-3">Supplier</p>
                              <select class="form-select select2-supplier number supplier-details mb-3" name="form_supplier" >

                                @foreach($all_sup as $sups)
                                  <option value='{{$sups->id}}'>{{$sups->name}}</option>
                                @endforeach
                              </select>




                            </div>

                            <div class="col-lg-2 col-md-6 col-12 mb-md-0 mb-3">
                              <p class="mb-2 repeater-title">Description</p>
                              <textarea class="form-control"  value="testNotes" name="form_part_desc" rows="1"></textarea>
                              <p class="mb-2 repeater-title mt-3">Unit Cost</p>
                              <input type="number" class="form-control invoice-item-price item-calculation mb-3"  name="form_unit_cost" placeholder="00" min="12" />
                            </div>
                            <div class="col-lg-2 col-md-6 col-12 mb-md-0 mb-3">
                              <p class="mb-2 repeater-title">Qty</p>
                              <input type="number" class="form-control invoice-item-price item-calculation mb-3"  name="form_qty"  placeholder="00" min="12" />
                              <p class="mb-2 repeater-title ">Total Cost</p>
                              <input type="number" class="form-control invoice-item-price item-calculation mb-3 item-total-cost"  readonly name="form_total_cost" placeholder="00" min="12" />

                            </div>
                            <div class="col-lg-2 col-md-6 col-12 mb-md-0 mb-3">
                              <p class="mb-2 repeater-title">Unit Selling Price</p>
                              <input type="number" class="form-control invoice-item-price mb-3 item-calculation " placeholder="00" min="12"  name="form_unit_selling_price" id="form-part-unit-selling-price" />



                              <p class="mb-2 repeater-title ">Freight</p>
                              <div class="input-group">
                                <input type="number" class="form-control item-freight item-calculation " placeholder="0" name="form_freight" aria-label="">
                                <span class="input-group-text">%</span>
                              </div>




                            </div>

                            <div class="col-lg-2 col-md-6 col-12 pe-0">
                              <p class="mb-2 repeater-title">Total Selling Price</p>
                              <input type="text"  class="form-control mb-3 total-selling-price" placeholder="00"  name="form_part_total_selling_price" />
                              <p class="mb-2 repeater-title ">Taxes/Duty (%)</p>
                              <div class="input-group">
                                <input type="number"  class="form-control item-freight item-calculation " placeholder="0"  name="form_taxes" aria-label="">
                                <span class="input-group-text">%</span>
                              </div>

                            </div>
                            <div class="col-lg-2 col-md-6 col-12 col-12 pe-0">
                              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Freight % * (Unit Cost * Currency)"> Freight Cost: RM</span>
                              <span class="freight-cost " name="freight_cost" >0</span>
                              <input type="hidden" class="total-freight-cost " name="total_freight_cost" ></input>
                              <input type="hidden" readonly name="form_freight_cost">
                              <p class="mb-0">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Taxes/Duty % * (Unit Cost * Currency)">Taxes/Duty Cost: RM</span>
                                <span class="taxduty-cost " name="taxduty_cost" >0</span>
                                <input type="hidden" class="total-taxduty-cost " name="total_taxduty_cost" ></input>
                                <input type="hidden" readonly name="form_taxduty_cost">
                              <p class="mb-0">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Taxes/Duty + Freight + (Unit Cost * Currency)">Unit landed Cost: RM</span>
                                <span class="unit-landed-cost " name="unit_landed_cost" >0</span>
                                <input type="hidden" name="form_unit_landed_cost">
                              <p class="mb-0">
                                <span >Profit: RM</span>
                                <span class="unit-item-profit " name="unit_item_profit" >0</span>
                                <input type="hidden" readonly name="form_unit_item_profit">


                              <p class=" repeater-title mb-1">Currency</p>
                              <div class="input-group">
                                <input type="number"  class="form-control item-calculation unit-currency " name="formInputcurrency" placeholder="0"  name="form_taxes" aria-label="">
                              </div>



                            </div>



                          </div>



                          <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                            <i class="ti ti-x cursor-pointer" data-repeater-delete></i>

                          </div>
                        </div>
                        <div class="d-flex border rounded position-relative pe-0">
                          <div class="row w-100 p-3">
                            <div class="col-lg-1 col-md-12 col-12 mb-md-0 mb-2 ">
                              <p class="mb-3 repeater-title">Stocks</p>
                              <div class="form-check ">
                                <input type="checkbox" class="form-check-input"  name="formItemStock" />
                                <label class="form-check-label" for="formItemStock">Check</label>
                              </div>


                            </div>

                            <div class="col-lg-3 col-md-6   col-12 mb-md-0 mb-3">
                              <div>
                                <p class="mb-2 repeater-title">Purchase Order</p>
                              </div>

                              <div class="input-group">
                                <div class="input-group-text">
                                  <input class="form-check-input m-lg-1" type="checkbox" name="form_po_check" > Check
                                </div>
                                <input type="text" class="form-control" name="form_po_no"  placeholder="PO No">
                              </div>
                              <p class="mb-2 mt-2 repeater-title">Invoice Order</p>
                              <div class="input-group">
                                <div class="input-group-text">
                                  <input class="form-check-input m-lg-1" type="checkbox" name="form_invoice_check" > Check
                                </div>
                                <input type="text" class="form-control" name="form_invoice_no"  placeholder="Invoice No">
                              </div>
                            </div>

                            <div class="col-lg-3 col-md-6  col-12 mb-md-0 mb-3">
                              <p class="mb-2 repeater-title">GR</p>
                              <div class="input-group">
                                <div class="input-group-text">
                                  <input class="form-check-input m-lg-1" type="checkbox" name="form_gr_check" > Check
                                </div>
                                <input type="text" name="form_gr_no" class="form-control" aria-label="Text input with checkbox" placeholder="GR No">
                              </div>
                              <p class="mb-2 mt-2 repeater-title">Delivery Order</p>
                              <div class="input-group">
                                <div class="input-group-text">
                                  <input class="form-check-input m-lg-1" type="checkbox" name="form_delivery_check" > Check
                                </div>
                                <input type="text" class="form-control" name="form_delivery_no"  placeholder="Delivery Order No">
                              </div>
                            </div>

                            <div class="col-lg-2 col-md-6 col-12 pe-0">
                              <p class="mb-2 repeater-title">Poison</p>
                              <label class="switch switch-danger switch-lg mt-1">
                                <input type="checkbox" class="switch-input" autocomplete="off" name="part_item_poison"/>
                                <span class="switch-toggle-slider">
                            <span class="switch-on">Yes
                              <i class="ti ti-check"></i>
                            </span>
                            <span class="switch-off">
                              <i class="ti ti-x"></i>
                            </span>
                          </span>
                                <span class="switch-label"></span>
                              </label>
                            </div>

                            <div class="col-lg-2 col-md-2 col-12 pe-0">
                              <p class="mb-2 repeater-title ">Margin</p>
                              <div class="input-group">
                                <input type="number" readonly class="form-control item-margin"  placeholder="0" name="form_item_margin" >
                                <span class="input-group-text">%</span>
                              </div>


                            </div>

                          </div>

                        </div>

                        <div class="d-flex border rounded position-relative pe-0">
                          <textarea class="form-control part-comment"  placeholder="Part Comment" value="part_item_note" name="part_item_note" rows="1"></textarea>
                        </div>
                        <hr>
                      </div>
                      <input type="hidden" name="field_sum_total_po_value">
                      <input type="hidden" name="field_sum_total_cost_of_goods">
                      <input type="hidden" name="field_sum_total_tax">
                      <input type="hidden" name="field_sum_total_shipping">
                      <input type="hidden" name="field_sum_total_gross_profit">
                      <input type="hidden" name="field_sum_total_gross_profit_percent">
                    </div>
                  </div>
                  <div class="col-md-6 mb-0">
                    <button type="button" class="btn btn-primary btn-repeater-add job_repeater" data-repeater-create>Add Item</button>
                  </div>
                </form>





                <div class="row p-0 p-sm-4">
                  <div class="col-md-6  mb-md-0 mb-3">
                    <div class="alert alert-danger  d-flex align-items-baseline" role="alert">
                      <span class="alert-icon alert-icon-lg text-secondary me-2">
                        <i class="ti ti-alert-triangle ti-sm"></i>
                      </span>
                      <div class="d-flex flex-column ps-1">
                        <h5 class="alert-heading mb-2">Accepted file types: pdf, jpg, jpeg and png.</h5>
                        <p class="mb-0">Maximun per file is 10MB.</p>

                        <p class="mb-0"> You can select multiple documents for the same type.</p>

                        <p class="mb-0">  Please use CamScanner mobile app to snapshot your document to convert into PDF.</p>
                      </div>
                    </div>
                    <form action="{{ route('opf.store.upload')  }}"  method="POST" class="dropzone needsclick" id="dropzone-multi" enctype="multipart/form-data">

                      @csrf<div class="dz-message needsclick">
                        Drop files here or click to upload
{{--                        <span class="note needsclick">(This is just a demo dropzone. Selected files are <span class="fw-medium">not</span> actually uploaded.)</span>--}}
                      </div>
                      <div class="fallback">
                        <input name="file[]" type="file" />

                      </div>
                      <input type="hidden" value="@if($opf->exists){{$opf->id}}@endif" name="opfid" id="opfid">
                    </form>
                  </div>
                  <div class="col-md-6  d-flex justify-content-end">
                    <div class="invoice-calculations">
                      <div class="d-flex justify-content-between mb-2">
                        <span class="w-px-200">Total PO value:</span>
                        <span class="fw-medium" name="sum_total_po_value">$00.00</span>

                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="w-px-10">Total Cost of Goods:</span>
                        <span class="fw-medium" name="sum_total_cost_of_goods">$00.00</span>

                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="w-px-10">Duty/Taxes:</span>
                        <span class="fw-medium"  name="sum_total_tax">$00.00</span>

                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="w-px-10">Shipping charges:</span>
                        <span class="fw-medium" name="sum_total_shipping">$00.00</span>

                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="w-px-10">Gross Profit:</span>
                        <span class="fw-medium" name="sum_total_gross_profit">$00.00</span>

                      </div>
                      <div class="d-flex justify-content-between mb-0">
                        <span class="w-px-10">% of Gross profit</span>
                        <span class="fw-medium" name="sum_total_gross_profit_percent">$00.00</span>

                      </div>
                    </div>
                  </div>
                </div>


                <!-- Choose Your Plan -->

                {{--            <div class="col-12">--}}
                {{--              <label class="switch switch-primary">--}}
                {{--                <input type="checkbox" class="switch-input" name="formValidationSwitch" />--}}
                {{--                <span class="switch-toggle-slider">--}}
                {{--                <span class="switch-on"></span>--}}
                {{--                <span class="switch-off"></span>--}}
                {{--              </span>--}}
                {{--                <span class="switch-label">Send me related emails</span>--}}
                {{--              </label>--}}
                {{--            </div>--}}
                {{--            <div class="col-12">--}}
                {{--              <div class="form-check">--}}
                {{--                <input type="checkbox" class="form-check-input" id="formValidationCheckbox" name="formValidationCheckbox" />--}}
                {{--                <label class="form-check-label" for="formValidationCheckbox">Agree to our terms and conditions</label>--}}
                {{--              </div>--}}
                {{--            </div>--}}
                {{--            <div class="col-12">--}}
                {{--              <button type="submit" name="submitButton" class="btn btn-primary">Submit</button>--}}
                {{--            </div>--}}

              </div>
            </div>

            </div>
            <div class="tab-pane fade" id="navs-top-opf-document" role="tabpanel">


              <div class="card">

                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                    <tr>
                      <th>Uploaded At</th>
                      <th>File Name</th>
                      <th>Upload By</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="tbody">


                    @if($opf->exists)

                      @foreach($opf_file as $opf_files)
                        <tr>
                          <td> <span class="fw-medium">{{$opf_files->created_at}}</span></td>
                          <td> <span class="fw-medium">{{$opf_files->file_name}}</span></td>
                          <td>{{$opf_files->upload_by}}</td>

                          <td>
                            <div class="d-flex align-items-center">
                              <a target="_blank"  href="{{ asset('storage/opf/uploads/'. $opf_files->opf_id.'/'.$opf_files->download_url) }}" class="text-body"><i class="ti ti-cloud-download ti-sm me-2"></i></a>
                              <a href="javascript:;" data-file="{{$opf_files->download_url}}" data-opf-id="{{$opf_files->opf_id}}"  class="text-body delete-file"><i class="ti ti-trash ti-sm mx-2"></i></a>
                            </div>
                          </td>


                        </tr>
                      @endforeach

                    </tbody>
                    @endif

                  </table>
                </div>
              </div>


            </div>
            <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
            </div>
          </div>
        </div>
      </div>
      <div class="card">

    </div>
  </div>
@endsection
