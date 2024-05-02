<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class urlhistory extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'old_status', 'new_status', 'url_ref'];
}
