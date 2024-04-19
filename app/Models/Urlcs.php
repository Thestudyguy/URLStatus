<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Urlcs extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'status'];
    public function URL() : HasMany{
        return $this->hasMany(UrlEmail::class, 'url_id');
    }
}
