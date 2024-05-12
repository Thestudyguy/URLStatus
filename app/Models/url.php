<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class url extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'status', 'owner'];
    public function gtmcodes(): HasMany
    {
        return $this->hasMany(Gtmcodes::class, 'url');
    }
}
