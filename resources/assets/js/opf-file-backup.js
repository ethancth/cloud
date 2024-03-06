/**
 * File Upload
 */

'use strict';

(function () {
  // previewTemplate: Updated Dropzone default previewTemplate
  // ! Don't change it unless you really know what you are doing
  const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;


  const dropzoneMulti = document.querySelector('#dropzone-multi');
  dropzoneMulti.autoDiscover = false;
  if (dropzoneMulti) {
    const myDropzoneMulti = new Dropzone(dropzoneMulti, {

      previewTemplate: previewTemplate,
      addRemoveLinks: false,
      uploadMultiple: true,
      parallelUploads: 10,
      autoProcessQueue: false, // this is important as you dont want form to be submitted unless you have clicked the submit button
      // autoDiscover: false,
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      // paramName: 'pics', // this is optional Like this one will get accessed in php by writing $_FILE['pic'] // if you dont specify it then bydefault it taked 'file' as paramName eg: $_FILE['file']
      // previewsContainer: '#dropzonePreview', // we specify on which div id we must show the files
      clickable: true, // this tells that the dropzone will not be clickable . we have to do it because v dont want the whole form to be clickable
      dictDefaultMessage: "Upload images here",
      maxFilesize: 3000, // MB
      maxFiles: 10,
      timeout: 60000,
      accept: function(file, done) {
        console.log("uploaded");
        done();
      },
      error: function(file, msg){
        console.log(msg);
      },
      init: function() {
        var myDropzone = this;
        //now we will submit the form when the button is clicked
        $("#btn-edit-form-two").on('click',function(e) {
          e.preventDefault();
          e.stopPropagation();
          $('#btn-edit-form-two').prop('disabled', true);
          var form = $(this).parents('form');
          var next_step = true;
          var current = $('.campaign_form_id').val();
          var opfid = $("[name='opf_id").val();
          if(opfid){
            console.log('opf id = '+opfid);
            $('#btn-edit-form-two').prop('disabled', false);
          }else{
            Swal.fire({
              title: 'Opf is not saving',
              text: 'Please Save the Opf 1st .',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            next_step=false;
            $('#btn-edit-form-two').prop('disabled', false);
          }
          if($(form)[0].checkValidity()) {

            if(next_step == true){

              if (myDropzone.getQueuedFiles().length > 0) {
                myDropzone.processQueue();
                console.log("sending now with dropzone");
              } else {
                $.ajax({
                  type: "POST",
                  url:"{{url('opf.store.upload')}}",
                  data: new FormData($(form)[0]),

                  processData: false,
                  contentType: false,

                  success: function(msg) {
                    console.log(msg)
                    if(msg != ""){
                      window.location.href = msg;
                    }
                  },
                  error: function (msg) {
                    var errors = msg.responseJSON;
                    errorsHtml = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>";

                    if(errors.errors != "" && errors.errors != undefined && errors.message != "") {

                      $.each(errors.errors, function (key, data) {
                        $.each(data, function (index, data) {
                          errorsHtml += '<p class="mb-0">'+ data + '</p>';
                        });
                      });

                    } else if (errors.message != "" && errors.message != undefined){
                      $.each(errors.message, function (key, data) {
                        errorsHtml += '<p class="mb-0">'+ data + '</p>';
                      });
                    }
                    errorsHtml += "</div>";
                    $('#edit-feedback-two').html(errorsHtml);
                    $('#edit-feedback-two').show();
                    $('#btn-edit-form-two').prop('disabled', false);
                  }
                });
                console.log("sending now without dropzone");
              }

              // myDropzone.processQueue(); // this will submit your form to the specified action path
            }
          }
          else {
            $(form)[0].reportValidity();
            $('#btn-edit-form-two').prop('disabled', false);
          }
          // after this, your whole form will get submitted with all the inputs + your files and the php code will remain as usual
          //REMEMBER you DON'T have to call ajax or anything by yourself, dropzone will take care of that
        });

        this.on("sending", function(file, xhr, formData){
        $("#edit-form-two").find("input").each(function(){
            formData.append($(this).attr("name"), $(this).val());
        });
        });
        this.on("sendingmultiple", function(file, xhr, formData) {
          // Gets triggered when the form is actually being sent.
          // Hide the success button or the complete form.
          $("#edit-form-two").find("input").each(function(){
            formData.append($(this).attr("name"), $(this).val());
            console.log($(this).attr("name") + " "+ $(this).val());
          });
        });
        this.on("successmultiple", function(files, response) {
          // Gets triggered when the files have successfully been sent.
          // Redirect user or notify of success.
        });
        this.on("errormultiple", function(files, response) {
          // Gets triggered when there was an error sending the files.
          // Maybe show form again, and notify user of error
        });
      } // init end


    });
  }
})();
