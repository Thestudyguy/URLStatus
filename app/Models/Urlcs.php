<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urlcs extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'status'];
}
