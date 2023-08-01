<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'image', 'summary', 'is_parent', 'parent_id', 'apparel', 'status'];

    // function to get rules
    public function getRules($act = 'add') 
    {
        $rules = [
            'title' => 'required|string',
            'image' => 'required|sometimes|max:5120',
            'summary' => 'nullable|string|',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
            'apparel' => 'nullable|exists:apparels,id'
            // 'status' => 'required|in:Active,Inactive'
        ];

        if($act == 'update'){
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

    public static function shiftChild($cat_id){
        return Category::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }

    public static function getChildByParentID($id){
        return Category::where('parent_id', $id)->pluck('title', 'id');
    }
}