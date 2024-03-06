<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class OpfItem extends Model
{
    use HasFactory;

  use LogsActivity;

//  public $incrementing = false;

  protected $fillable = [
    'opf_id',
    'supplier_id',
    'supplier_name',
    'part_id',
    'part_description',
    'part_name',
    'unit_cost',
    'qty',
    'freight',
    'unit_selling_price',
    'taxes',
    'total_selling_price',
    'total_cost',
    'freight_cost',
    'taxes_cost',
    'unit_landed_cost',
    'profit',
    'stock_check',
    'po_check',
    'po_number',
    'gr_check',
    'gr_number',
    'is_poison',
    'margin',
    'currency',
    'total_gr_check',
    'part_comment',
    'do_check',
    'do_number',
    'invoice_check',
    'invoice_number'
    ];

  public function opf()
  {
    return $this->hasOne(Opf::class,'id','opf_id'
    );
  }


  public function getActivitylogOptions():LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('OPFItemActivity')
      ->logAll()
      ->dontSubmitEmptyLogs()
      ->logOnlyDirty();
  }
}
