<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'status'];
    
    // function to get rules
    public function getRules($act = 'add')
    {
        $rules = [
            'title' => 'required|string',
            'image' => 'required|image|max:5120',
        ];

        if ($act == 'update') {
            $rules['image'] = 'sometimes|image|max:5120';
        }

        return $rules;
    }

    // function to get slug
    public function getSlug($title){
        $slug = Str::slug($title);
        if ($this->where('slug',$slug)->count() > 0){
            $slug .= date('Ymdhis').rand(0,99);
        }
        return $slug;
    }

    public function products(){
        return $this->hasMany('App\Models\Product')->where('status', 'active');
    }
}
