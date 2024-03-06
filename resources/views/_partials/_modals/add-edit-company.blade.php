<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCompany" aria-labelledby="offcanvasAddCompanyLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasAddCompanyLabel" class="offcanvas-title">Add</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body mx-0 flex-grow-0">
    <form class="add-new-user pt-0" id="addNewCompanyForm">
      <input type="hidden" name="id" id="_id">
      <div class="mb-3">
        <label class="form-label" for="_name">Company Name</label>
        <input type="text" class="form-control" id="_name" placeholder="Company Display Name" name="name" aria-label="" />
      </div>
      <div class="mb-3">
        <label class="form-label" for="_name">Address</label>
        <textarea class="form-control" placeholder="Address"  id="address_1" name="address_1"  ></textarea>
      </div>
      <div class="mb-3">
        <label for="currency" class="form-label">Currency</label>
        <select id="currency" name="currency" class="select2 form-select form-select-lg search-currency" data-allow-clear="true">
          @foreach($cRates as $_value)
            <option value="{{$_value->name}}">{{$_value->name}}</option>
          @endforeach

        </select>
      </div>
      <div class="mb-3">
        <label class="form-label" for="currency_rate">Rates</label>
        <div class="input-group">
          {{--            <div class="input-group-text">--}}
          {{--              <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">--}}
          {{--            </div>--}}
          <input type="text" class="form-control" aria-label="Text input with checkbox" readonly id ="currency_rate" name="currency_rate">
        </div>

      </div>

      <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
    </form>
  </div>
</div>
