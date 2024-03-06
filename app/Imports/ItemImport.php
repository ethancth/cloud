<?php

namespace App\Imports;

use App\Models\ItemInv;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      if ($row[0] === null || $row[1] === null|| $row[2] === null|| $row[3] === null ) {
      return null;
    }

      return new ItemInv([
            //
          'name'     => $row[1],
          'part_number'    => $row[0] ,
          'description' => $row[1],
          'supplier_id' =>$row[4],
          'supplier_name' =>$row[3],
          'slug' =>$row[0].' '.$row[1]. '' .$row[3],
          'price' =>1,
          'base_rate' =>1,
          'currency_rate' =>1,
          'currency' =>'MYR',
          'status' =>'1',
          'long_desc' =>$row[2],
        ]);
    }

  public function rules(): array
  {
    return [
      '0' => 'required|string',
      '1' => 'required|string',
      '2' => 'required|string',
      // so on
    ];
  }


}
