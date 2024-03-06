<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pic extends Model
{
    use HasFactory;

  use LogsActivity;

  protected $fillable = [
    'name',
    'contact',
    'email',
    'company_id',
    'company_name',
    'status',
  ];

  public function scopeWithInActive($query)
  {
    return $query->where('status', 1);
  }

  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('PICActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
