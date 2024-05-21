<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class client extends Model
{
    use HasFactory;
    protected $fillable = ['client', 'email', 'contact'];
    public function email() : HasMany {
        return $this->hasMany(email::class, 'client');
    }
    public function url() : HasMany {
        return $this->hasMany(url::class, 'owner');
    }
}
