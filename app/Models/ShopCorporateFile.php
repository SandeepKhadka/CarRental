<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCorporateFile extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'legal_name', 'pan_no', 'image'];
}
