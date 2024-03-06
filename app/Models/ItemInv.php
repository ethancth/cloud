<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ItemInv extends Model
{
    use HasFactory;
  use LogsActivity;

  protected $fillable = [
    'name',
    'part_number',
    'description',
    'long_desc',
    'slug',
    'supplier_id',
    'supplier_name',
    'currency_rate',
    'base_rate',
    'price',
    'currency',
    'status',
    'is_poison'
  ];

  public function scopeWithInActive($query)
  {
    return $query->where('status', 1);
  }



  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('DivisionActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
