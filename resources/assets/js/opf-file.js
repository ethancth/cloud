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
  Dropzone.autoDiscover = false;
  if (dropzoneMulti) {
    const myDropzoneMulti = new Dropzone(dropzoneMulti, {

      maxFilesize: 10,
      renameFile: function(file) {
        var dt = new Date();
        var time = dt.getTime();
        return file.name;
      },
      acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
      addRemoveLinks: true,
      timeout: 5000,
      success: function(file, response)
      {
        $('#tbody').load(document.URL +  ' #tbody tr');
        $('#footer_opf').load(document.URL +  ' #footer_opf');
      },
      error: function(file, response)
      {
        return false;
      }


    });

  }


  $(document).on('click', '.delete-file', function() {

    var id = $(this).data('file');
    var opfid = $(this).data('opf-id');
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
        $.ajax({

          type:"POST",
          url: "/app/opf/deletefile",
          data: { id: id ,opfid: opfid},
          dataType: 'json',
          success: function () {
            $('#tbody').load(document.URL +  ' #tbody tr');
            $('#footer_opf').load(document.URL +  ' #footer_opf');
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: 'The file has been delete!',
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
})();

