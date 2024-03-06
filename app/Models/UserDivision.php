<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

use Spatie\Activitylog\Traits\LogsActivity;

class UserDivision extends Model
{
    use HasFactory;

  use LogsActivity;

  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('UserDivisionActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
