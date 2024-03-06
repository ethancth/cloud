<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSelectAddress" aria-labelledby="offcanvasSelectAddressLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasSelectAddressLabel" class="offcanvas-title">Select Address</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body mx-0 flex-grow-0">

      <input type="hidden" name="company_address_id" id="company_address_id">
      <div class="mb-3">
        <label class="form-label" for="companyaddressdescription">Address Description</label>
        <select id="companyaddressdescription" name="companyaddressdescription" class="select2 form-select form-select-lg search-addressbook" data-allow-clear="true">
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label" for="address_book_billing_address">Billing Address</label>
        <textarea class="form-control"  placeholder="Billing Address"  id="address_book_billing_address" name="address_book_billing_address"  rows="4" ></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label" for="address_book_delivery_address">Delivery Address</label>
        <textarea class="form-control"  placeholder="Address"  id="address_book_delivery_address" name="address_book_delivery_address"  rows="4" ></textarea>
      </div>


      <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit-addressbook">Select</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
  </div>
</div>
