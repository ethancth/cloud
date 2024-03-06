@php
$containerFooter = (isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme" id="footer_opf">
  <div class="{{ $containerFooter }}" >

      @if(request()->path()=='app/opf/create'|| substr(request()->path(),0,12)=='app/opf/form')

      <div class="footer-container d-flex align-items-end justify-content-end py-2">
        <script>
          window.Helpers.setFooterFixed(true);
        </script>

      <div class="card">
        <div class=" text-end">
{{--          <button type="button" class="btn btn-outline-secondary me-1 waves-effect">Save as Draft</button>--}}

{{--          <input type="submit" name="submitButton"  form="formOPF" class="btn btn-primary">Save</input>--}}
          <button type="submit" name="submitButton" form="formOPF" class="btn btn-outline-secondary me-1 waves-effect" value="Update">Save</button>

          @if($opf->file->count()>0 && $opf->item->count() >0 && $opf->opf_status=='draft')
          <button type="submit" name="updateButton" form="" class="btn btn-primary me-1 waves-effect submit-opf" data-id="{{$opf->id}}"value="">Submit</button>
          @endif
        </div>
      </div>

@else
          <div class="footer-container d-flex align-items-left py-2">
        <script>
          window.Helpers.setFooterFixed(false);
        </script>


      <div>
        © <script>
          document.write(new Date().getFullYear())
      </script>
    , Gamma Scientific. All rights reserved.
{{--        , made with ❤️ by <a href="{{ (!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '') }}" target="_blank" class="footer-link fw-medium">{{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : '') }}</a>--}}
      </div>
      @endif
      <div class="d-none d-lg-inline-block">
      </div>
    </div>
  </div>
</footer>
<!--/ Footer-->
