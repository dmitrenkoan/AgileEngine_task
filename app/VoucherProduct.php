<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['products_id', 'vouchers_id'];
}
