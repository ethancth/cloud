<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Position extends Model
{

  use LogsActivity;
  protected $table = 'roles';

  protected $fillable = [
    'name','status','guard_name'
  ];


  public function member()
  {
    return $this->belongsToMany(User::class,'user_positions','position_id','user_id'
    );
  }

  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('PositionActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
