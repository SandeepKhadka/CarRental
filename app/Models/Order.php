<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'oid', 'order_number', 'payment_status', 'condition', 'payment_method', 'product_id', 'sub_total', 'total_amount', 'quantity', 'delivery_charge', 'coupon', 'first_name', 'last_name', 'email', 'address', 'phone', 'country', 'state', 'postcode', 'city', 'note', 'sfirst_name', 'slast_name', 'semail', 'saddress', 'sphone', 'scountry', 'sstate', 'spostcode', 'scity'];

    public function products(){
        return $this->belongsToMany(Product::class, 'product_orders')->withPivot('quantity');
    }

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }


}
