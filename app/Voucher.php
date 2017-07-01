<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = ['IDs', 'start_date' , 'end_date', 'discount_tiers_id'];
}
