<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Seller extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable; 

    protected $fillable = ['full_name', 'username', 'email', 'email_verified_at', 'password', 'photo', 'phone', 'status'];
}
