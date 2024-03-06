<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\CurrencyRate;
class CurrencyObserver
{
    //
  public function updated(CurrencyRate $currencyrate): void
  {
    // ...

    $_old_data=$currencyrate->getDirty();
    if(!array_key_exists('name',$_old_data)){
      $_old_data['name']=$currencyrate->name;
    }

    $_load_all_company=Company::where('currency','=',$_old_data['name'])->get();
    foreach($_load_all_company as $record)
    {
      $record->currency_rate=$_old_data['rate'];
      $record->save();
    }

  }

}
