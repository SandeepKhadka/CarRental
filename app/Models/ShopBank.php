<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopBank extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'account_type', 'account_no', 'bank_name', 'branch_name'];
}
