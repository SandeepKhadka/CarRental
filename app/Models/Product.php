<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'summary', 'description', 'additional_info', 'points', 'return_cancellation', 'size_guide', 'stock', 'price', 'offer_price', 'discount', 'conditions', 'status', 'image', 'vendor_id', 'brand_id', 'cat_id', 'child_cat_id', 'size'];

    public function getSlug($title){
        $slug = Str::slug($title);
        if ($this->where('slug',$slug)->count() > 0){
            $slug .= date('Ymdhis').rand(0,99);
        }
        return $slug;
    }

    public static function getProductByCart($id){
        return self::where('id',$id)->get()->toArray();
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'product_orders')->withPivot('quantity');
    }
}
