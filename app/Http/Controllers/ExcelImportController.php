<?php

namespace App\Http\Controllers;
use App\Imports\ItemImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExcelImportController extends Controller
{
    //

  public function import(Request $request)
  {
    // Validate the uploaded file
    $request->validate([
      'file' => 'required|mimes:xlsx,xls',
    ]);

    // Get the uploaded file
    $file = $request->file('file');

    // Process the Excel file
    Excel::import(new ItemImport(), $file);

    return redirect()->back()->with('success', 'Excel file imported successfully!');
  }

  public function index()
  {
    return view('content.import.index');
  }
}
