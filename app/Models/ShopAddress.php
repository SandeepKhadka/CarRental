<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopAddress extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'address', 'country_region', 'province', 'city', 'area'];
}
