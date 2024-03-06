<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class OpfUpload extends Model
{
    use HasFactory;

  use LogsActivity;

    protected $fillable=[

    'file_name', 'download_url', 'upload_by','opf_id','download_count','file_size','status'
    ];


  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('OPFFileUploadActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
