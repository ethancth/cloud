<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Model
{

  use LogsActivity;

  protected $fillable = [
    'name',
    'address_1',
    'billing_address',
    'address_2',
    'address_3',
    'city',
    'state',
    'zip',
    'country',
    'status',
    'is_custom_rate',
    'currency_rate',
    'currency'
  ];

  public function scopeWithInActive($query)
  {
    return $query->where('status', 1);
  }

  public function addressbook()
  {
    return $this->hasMany(CompanyAddress::class,'company_id','id');
  }

  public function defaultaddressbook()
  {
    return $this->hasOne(CompanyAddress::class,'company_id','id')->where('is_default',1);
  }

  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('CompanyActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
