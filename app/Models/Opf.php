<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Opf extends Model
{

use HasFactory;
use LogsActivity;
  protected $casts = [
    'created_at' => 'datetime'
  ];

  protected $fillable = [
    'opf_no',
    'customer_id',
    'customer_name',
    'customer_address',
    'po_value',
    'pic_email',
    'sales_person',
    'current_division',
    'due_date',
    'gr_status',
    'status',
    'currency',
    'currency_rate',
    'pic_id',
    'pic_name',
    'contact',
    'sales_person_id',
    'notes',
    'slug',
    'customer_delivery_address',
    'customer_billing_address',
    'total_po',
    'total_cost_of_goods',
    'total_tax',
    'total_shipping',
    'gross_profit',
    'gross_profit_percent',
    'grn_status',
    'grn_rate',
    'tags',
    'opf_status',
    'submitted_by',
    'approve_by',
    'created_by',
    'submited_at',
    'approve_at',
  ];


  public function item()
  {
    return $this->hasMany(OpfItem::class,'opf_id','id'
    );
  }

  public function file()
  {
    return $this->hasMany(OpfUpload::class,'opf_id','id')->where('status','=',1);
  }

  protected static $recordEvents = ['deleted','updated','created'];

  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('OPFActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
