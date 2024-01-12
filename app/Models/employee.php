<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'fullname', 
        'email', 
        'phone'
    ];
}