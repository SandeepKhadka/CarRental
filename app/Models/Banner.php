<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'image', 'status', 'condition'];

    // function to get rules
    public function getRules($act = 'add')
    {
        $rules = [
            'title' => 'required|string',
            'description' => 'nullable|string',
            // 'image' => 'required|image|max:5120',
            'image' => 'required',
            'condition' => 'nullable|in:banner,promo',
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
}
