<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CompanyAddress extends Model
{
    use HasFactory;

  use LogsActivity;

    protected $fillable=[
      'description',
      'company_id',
      'delivery_address',
      'billing_address',
      'status',
      'is_default'
    ];

  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('CompanyAddressActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
