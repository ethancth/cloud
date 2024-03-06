@extends('layouts/layoutMaster')

@section('title', 'Validation - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
      const formValidationExamples = document.getElementById('formValidationExamples'),
        formValidationSelect2Ele = jQuery(formValidationExamples.querySelector('[name="formValidationSelect2"]')),
        formValidation2Select2Ele = jQuery(formValidationExamples.querySelector('[name="formValidation2Select2"]')),
        formValidationTechEle = jQuery(formValidationExamples.querySelector('[name="formValidationTech"]')),
        formValidationLangEle = formValidationExamples.querySelector('[name="formValidationLang"]'),
        formValidationHobbiesEle = jQuery(formValidationExamples.querySelector('.selectpicker')),
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

      const fv = FormValidation.formValidation(formValidationExamples, {
        fields: {
          formValidationName: {
            validators: {
              notEmpty: {
                message: 'Please enter your name123'
              },
              stringLength: {
                min: 6,
                max: 30,
                message: 'The name must be more than 6 and less than 30 characters long'
              },
              regexp: {
                regexp: /^[a-zA-Z0-9 ]+$/,
                message: 'The name can only consist of alphabetical, number and space'
              }
            }
          },
          formValidationEmail: {
            validators: {
              notEmpty: {
                message: 'Please enter your email'
              },
              emailAddress: {
                message: 'The value is not a valid email address'
              }
            }
          },
          formValidationPass: {
            validators: {
              notEmpty: {
                message: 'Please enter your password'
              }
            }
          },
          formValidationConfirmPass: {
            validators: {
              notEmpty: {
                message: 'Please confirm password'
              },
              identical: {
                compare: function () {
                  return formValidationExamples.querySelector('[name="formValidationPass"]').value;
                },
                message: 'The password and its confirm are not the same'
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
          formValidationDob: {
            validators: {
              notEmpty: {
                message: 'Please select your DOB'
              },
              date: {
                format: 'YYYY/MM/DD',
                message: 'The value is not a valid date'
              }
            }
          },
          formValidationSelect2: {
            validators: {
              notEmpty: {
                message: 'Please select your country'
              }
            }
          },
          formValidationLang: {
            validators: {
              notEmpty: {
                message: 'Please add your language'
              }
            }
          },
          formValidationTech: {
            validators: {
              notEmpty: {
                message: 'Please select technology'
              }
            }
          },
          formValidationHobbies: {
            validators: {
              notEmpty: {
                message: 'Please select your hobbies'
              }
            }
          },
          formValidationBio: {
            validators: {
              notEmpty: {
                message: 'Please enter your bio'
              },
              stringLength: {
                min: 100,
                max: 500,
                message: 'The bio must be more than 100 and less than 500 characters long'
              }
            }
          },
          formValidationGender: {
            validators: {
              notEmpty: {
                message: 'Please select your gender'
              }
            }
          },
          formValidationPlan: {
            validators: {
              notEmpty: {
                message: 'Please select your preferred plan'
              }
            }
          },
          formValidationSwitch: {
            validators: {
              notEmpty: {
                message: 'Please select your preference'
              }
            }
          },
          formValidationCheckbox: {
            validators: {
              notEmpty: {
                message: 'Please confirm our T&C'
              }
            }
          }
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
                case 'formValidationName':
                case 'formValidationEmail':
                case 'formValidationPass':
                case 'formValidationConfirmPass':
                case 'formValidationFile':
                case 'formValidationDob':
                case 'formValidationSelect2':
                case 'formValidationLang':
                case 'formValidationTech':
                case 'formValidationHobbies':
                case 'formValidationBio':
                case 'formValidationGender':
                  return '.col-md-6';
                case 'formValidationPlan':
                  return '.col-xl-3';
                case 'formValidationSwitch':
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
          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
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
      });

      //? Revalidation third-party libs inputs on change trigger

      // Flatpickr
      flatpickr(formValidationExamples.querySelector('[name="formValidationDob"]'), {
        enableTime: false,
        // See https://flatpickr.js.org/formatting/
        dateFormat: 'Y/m/d',
        // After selecting a date, we need to revalidate the field
        onChange: function () {
          fv.revalidateField('formValidationDob');
        }
      });

      // Select2 (Country)
      if (formValidationSelect2Ele.length) {
        formValidationSelect2Ele.wrap('<div class="position-relative"></div>');
        formValidationSelect2Ele
          .select2({
            placeholder: 'Select country',
            dropdownParent: formValidationSelect2Ele.parent()
          })
          .on('change.select2', function () {
            // Revalidate the color field when an option is chosen
            fv.revalidateField('formValidationSelect2');
          });
      }

      if (formValidation2Select2Ele.length) {
        console.log(formValidation2Select2Ele);
        formValidation2Select2Ele.wrap('<div class="position-relative"></div>');
        formValidation2Select2Ele
          .select2({
            placeholder: 'Select country',
            dropdownParent: formValidation2Select2Ele.parent()
          })
          .on('change.select2', function () {
            // Revalidate the color field when an option is chosen
            fv.revalidateField('formValidation2Select2');
          });
      }

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

      // Tagify
      let formValidationLangTagify = new Tagify(formValidationLangEle);
      formValidationLangEle.addEventListener('change', onChange);
      function onChange() {
        fv.revalidateField('formValidationLang');
      }

      //Bootstrap select
      formValidationHobbiesEle.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        fv.revalidateField('formValidationHobbies');
      });
    })();
  });

</script>
@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Forms /</span> Validation
</h4>

<div class="row">
  <!-- FormValidation -->
  <div class="col-12">
    <div class="card">
      <h5 class="card-header">FormValidation</h5>
      <div class="card-body">

        <form id="formValidationExamples" class="row g-3">

          <!-- Account Details -->

          <div class="col-12">
            <h6>1. Account Details</h6>
            <hr class="mt-0" />
          </div>


          <div class="col-md-6">
            <label class="form-label" for="formValidationName">Full Name</label>
            <input type="text" id="formValidationName" class="form-control" placeholder="John Doe" name="formValidationName" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="formValidationEmail">Email</label>
            <input class="form-control" type="email" id="formValidationEmail" name="formValidationEmail" placeholder="john.doe" />
          </div>

          <div class="col-md-6">
            <div class="form-password-toggle">
              <label class="form-label" for="formValidationPass">Password</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" id="formValidationPass" name="formValidationPass" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-password2" />
                <span class="input-group-text cursor-pointer" id="multicol-password2"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-password-toggle">
              <label class="form-label" for="formValidationConfirmPass">Confirm Password</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" id="formValidationConfirmPass" name="formValidationConfirmPass" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multicol-confirm-password2" />
                <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>


          <!-- Personal Info -->

          <div class="col-12">
            <h6 class="mt-2">2. Personal Info</h6>
            <hr class="mt-0" />
          </div>

          <div class="col-md-6">
            <label for="formValidationFile" class="form-label">Profile Pic</label>
            <input class="form-control" type="file" id="formValidationFile" name="formValidationFile">
          </div>
          <div class="col-md-6">
            <label class="form-label" for="formValidationDob">DOB</label>
            <input type="text" class="form-control flatpickr-validation" name="formValidationDob" id="formValidationDob" required />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="formValidationSelect2">Country</label>
            <select id="formValidationSelect2" name="formValidationSelect2" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
              <option value="Australia">Australia</option>
              <option value="Bangladesh">Bangladesh</option>
              <option value="Belarus">Belarus</option>
              <option value="Brazil">Brazil</option>
              <option value="Canada">Canada</option>
              <option value="China">China</option>
              <option value="France">France</option>
              <option value="Germany">Germany</option>
              <option value="India">India</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Israel">Israel</option>
              <option value="Italy">Italy</option>
              <option value="Japan">Japan</option>
              <option value="Korea">Korea, Republic of</option>
              <option value="Mexico">Mexico</option>
              <option value="Philippines">Philippines</option>
              <option value="Russia">Russian Federation</option>
              <option value="South Africa">South Africa</option>
              <option value="Thailand">Thailand</option>
              <option value="Turkey">Turkey</option>
              <option value="Ukraine">Ukraine</option>
              <option value="United Arab Emirates">United Arab Emirates</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="United States">United States</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="formValidation2Select2">Country</label>
            <select id="formValidation2Select2" name="formValidation2Select2" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
              <option value="Australia">Australia</option>
              <option value="Bangladesh">Bangladesh</option>
              <option value="Belarus">Belarus</option>
              <option value="Brazil">Brazil</option>
              <option value="Canada">Canada</option>
              <option value="China">China</option>
              <option value="France">France</option>
              <option value="Germany">Germany</option>
              <option value="India">India</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Israel">Israel</option>
              <option value="Italy">Italy</option>
              <option value="Japan">Japan</option>
              <option value="Korea">Korea, Republic of</option>
              <option value="Mexico">Mexico</option>
              <option value="Philippines">Philippines</option>
              <option value="Russia">Russian Federation</option>
              <option value="South Africa">South Africa</option>
              <option value="Thailand">Thailand</option>
              <option value="Turkey">Turkey</option>
              <option value="Ukraine">Ukraine</option>
              <option value="United Arab Emirates">United Arab Emirates</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="United States">United States</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="formValidationLang">Languages</label>
            <input type="text" value="" class="form-control" name="formValidationLang" id="formValidationLang" />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="formValidationTech">Tech</label>
            <input class="form-control typeahead" type="text" id="formValidationTech" name="formValidationTech" autocomplete="off" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="formValidationHobbies">Hobbies</label>
            <select class="selectpicker  hobbies-select w-100" id="formValidationHobbies" data-style="btn-default" data-icon-base="ti" data-tick-icon="ti-check text-white" name="formValidationHobbies" multiple>
              <option>Sports</option>
              <option>Movies</option>
              <option>Books</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="formValidationBio">Bio</label>
            <textarea class="form-control" id="formValidationBio" name="formValidationBio" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label">Gender</label>
            <div class="form-check custom mb-2">
              <input type="radio" id="formValidationGender" name="formValidationGender" class="form-check-input" checked/>
              <label class="form-check-label" for="formValidationGender">Male</label>
            </div>

            <div class="form-check custom">
              <input type="radio" id="formValidationGender2" name="formValidationGender" class="form-check-input" />
              <label class="form-check-label" for="formValidationGender2">Female</label>
            </div>
          </div>


          <!-- Choose Your Plan -->

          <div class="col-12">
            <h6 class="mt-2">3. Choose Your Plan</h6>
            <hr class="mt-0" />
          </div>
          <div class="row gy-3 mt-0">
            <div class="col-xl-3 col-md-5 col-sm-6 col-12">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="basicPlanMain1">
                  <span class="custom-option-body">
                    <i class="ti ti-brand-telegram"></i>
                    <span class="custom-option-title"> Starter </span>
                    <small> Get 5gb of space and 1 team member. </small>
                  </span>
                  <input name="formValidationPlan" class="form-check-input" type="radio" value="" id="basicPlanMain1" checked />
                </label>
              </div>
            </div>
            <div class="col-xl-3 col-md-5 col-sm-6 col-12">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="basicPlanMain2">
                  <span class="custom-option-body">
                    <i class="ti ti-users"></i>
                    <span class="custom-option-title"> Personal </span>
                    <small> Get 15gb of space and 5 team member. </small>
                  </span>
                  <input name="formValidationPlan" class="form-check-input" type="radio" value="" id="basicPlanMain2" />
                </label>
              </div>
            </div>
            <div class="col-xl-3 col-md-5 col-sm-6 col-12">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="basicPlanMain3">
                  <span class="custom-option-body">
                    <i class="ti ti-crown"></i>
                    <span class="custom-option-title"> Premium </span>
                    <small> Get 25gb of space and 15 members. </small>
                  </span>
                  <input name="formValidationPlan" class="form-check-input" type="radio" value="" id="basicPlanMain3" />
                </label>
              </div>
            </div>
          </div>

          <div class="col-12">
            <label class="switch switch-primary">
              <input type="checkbox" class="switch-input" name="formValidationSwitch" />
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label">Send me related emails</span>
            </label>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="formValidationCheckbox" name="formValidationCheckbox" />
              <label class="form-check-label" for="formValidationCheckbox">Agree to our terms and conditions</label>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" name="submitButton" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /FormValidation -->
</div>
@endsection
