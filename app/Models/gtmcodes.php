<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gtmcodes extends Model
{
    use HasFactory;
    protected $fillable = ['gtm_codes', 'url'];
}
