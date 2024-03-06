<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddPIC" aria-labelledby="offcanvasAddPICLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasAddPICLabel" class="offcanvas-title">Create New Person In Charge</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body mx-0 flex-grow-0">
    <form class="add-new-user pt-0" id="addPICRecordForm">
      <input type="hidden" name="id" id="_id">
      <div class="mb-3">
        <label class="form-label" for="_name">PIC Name</label>
        <input type="text" class="form-control" id="_name" placeholder="Name" name="name" aria-label="" />
      </div>
      <div class="mb-3">
        <label for="company" class="form-label">Company</label>
        <select id="_company" name="company" class="select2 form-select form-select-lg search-company" data-allow-clear="true">
          <option value="">Select</option>
          @foreach($company as $_value)
            <option value="{{$_value->id}}">{{$_value->name}}</option>
          @endforeach

        </select>
      </div>
      <div class="mb-3">
        <label class="form-label" for="_name">Contact</label>
        <input type="text" class="form-control" placeholder="Contact"  id="_contact" name="contact"  >
      </div>
      <div class="mb-3">
        <label class="form-label" for="_name">Email</label>
        <input type="email" class="form-control" placeholder="Email Address"  id="_email" name="email"  >
      </div>


      <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
    </form>
  </div>
</div>
