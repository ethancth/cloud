<?php

use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\management\CompanyManagement;
use App\Http\Controllers\management\CurrencyManagement;
use App\Http\Controllers\management\DivisionManagement;
use App\Http\Controllers\management\ItemInvManagement;
use App\Http\Controllers\management\PICManagement;
use App\Http\Controllers\management\PositionManagement;
use App\Http\Controllers\management\SupplierManagement;
use App\Http\Controllers\OpfController;
use App\Http\Controllers\OpfReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\management\UserManagement;
use App\Http\Controllers\language\LanguageController;

// Main Page Route



Route::get('/app/opf/pdf/view/{id}', [OpfController::class, 'view_opf_pdf'])->name('opf.pdf.view');
Route::get('/app/opf/pdf/download/{id}', [OpfController::class, 'downloadpdf'])->name('opf.pdf.download');
Route::get('/app/opf/pdf/{id}', [OpfController::class, 'download_opf_pdf'])->name('opf.pdf');

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {


  //Route::get('opf/download/excel', [OpfReportController::class, 'export']);



Route::get('/', [OpfController::class, 'list'])->name('app-opf-list');
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/user-management', [UserManagement::class, 'UserManagement'])->name('user-management');
Route::resource('/user-list', UserManagement::class);
Route::resource('/division-list', DivisionManagement::class);
Route::resource('/position-list', PositionManagement::class);
Route::resource('/company-list', CompanyManagement::class);
Route::resource('/supplier-list', SupplierManagement::class);
Route::resource('/currency-list', CurrencyManagement::class);
Route::resource('/pic-list', PICManagement::class);
Route::resource('/iteminv-list', ItemInvManagement::class);


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

  Route::get('/division-management', [DivisionManagement::class, 'DivisionManagement'])->name('division-management');
  Route::get('/item-inventory-management', [ItemInvManagement::class, 'ItemInvManagement'])->name('item-inventory-management');
  Route::get('/position-management', [PositionManagement::class, 'PositionManagement'])->name('position-management');
  Route::get('/company-management', [CompanyManagement::class, 'CompanyManagement'])->name('company-management');
  Route::get('/supplier-management', [SupplierManagement::class, 'SupplierManagement'])->name('supplier-management');
  Route::get('/currency-management', [CurrencyManagement::class, 'CurrencyManagement'])->name('currency-management');
  Route::get('/person-in-charge-management', [\App\Http\Controllers\management\PICManagement::class, 'PICManagement'])->name('person-in-charge-management');

  Route::get('/app/opf/list', [OpfController::class, 'list'])->name('app-opf-list');
  Route::get('/opf-list', [OpfController::class, 'index'])->name('opf-list');
  Route::get('/app/opf/create', [OpfController::class, 'createform'])->name('app-opf-create-form');
  Route::post('/app/opf/uploadfile', [OpfController::class, 'file_upload'])->name('opf.store.upload');
  Route::post('/app/opf/deletefile', [OpfController::class, 'file_delete'])->name('opf.file.delete');
  Route::post('/app/opf/submit', [OpfController::class, 'submit_opf'])->name('opf.submit');
  Route::get('/app/opf/report', [OpfReportController::class, 'summary_report'])->name('app-opf-report');


  //Route::resource('/app-opf', OpfController::class);

  //OPF Resources

  Route::post('app/opf/create', [OpfController::class, 'store'])->name('app-opf-create-form');
  Route::get('app/opf/form/{opf}', [OpfController::class, 'view'])->name('app-opf-form');

  Route::get('/company/{company}/address-book', [\App\Http\Controllers\CompanyAddressController::class, 'list'])->name('company-management');
  Route::get('/company/{company}/addressbook/detail', [\App\Http\Controllers\CompanyAddressController::class, 'index'])->name('company-management');
  Route::delete('/company/{company}/addressbook/{id}', [\App\Http\Controllers\CompanyAddressController::class, 'destroy'])->name('company-management');
  Route::post('/company/{company}/addressbook/', [\App\Http\Controllers\CompanyAddressController::class, 'store'])->name('company-management');
  Route::get('/company/{company}/addressbook/{id}/edit', [\App\Http\Controllers\CompanyAddressController::class, 'edit'])->name('company-management');



  //import

  Route::get('/import-excel', [\App\Http\Controllers\ExcelImportController::class, 'index'])->name('import.excel');
  Route::post('/import-excel', [ExcelImportController::class, 'import']);





  //Json Route

  Route::get('getCompany', [\App\Http\Controllers\SearchController::class, 'getCompany'])->name('getCompany');
  Route::get('getCompanyAjax', [\App\Http\Controllers\SearchController::class, 'getCompanyAjax'])->name('getCompanyAjax');
  Route::get('getCurrencyRate', [\App\Http\Controllers\SearchController::class, 'getCurrencyRate'])->name('getCurrencyRate');
  Route::get('getAddressBookInfo', [\App\Http\Controllers\SearchController::class, 'getAddressBookInfo'])->name('getAddressBookInfo');
  Route::get('getCustomerAddressBook', [\App\Http\Controllers\SearchController::class, 'getCustomerAddressBook'])->name('getCustomerAddressBook');
  Route::get('getSupplierInfo', [\App\Http\Controllers\SearchController::class, 'getSupplierInfo'])->name('getSupplierInfo');
  Route::get('getPic', [\App\Http\Controllers\SearchController::class, 'getPic'])->name('getPic');
  Route::get('getSalesPerson', [\App\Http\Controllers\SearchController::class, 'getSalesPerson'])->name('getSalesPerson');
  Route::get('getItemInv', [\App\Http\Controllers\SearchController::class, 'getItemInv'])->name('getItemInv');
  Route::get('getSupplierItem', [\App\Http\Controllers\SearchController::class, 'getSupplierItem'])->name('getSupplierItem');
  Route::get('getOpfItem', [\App\Http\Controllers\SearchController::class, 'getOpfItem'])->name('getOpfItem');

});
