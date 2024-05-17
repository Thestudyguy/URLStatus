<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class url extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'status', 'owner'];
    public function history() : HasMany
    {
        return $this->hasMany(urlhistory::class, 'url_id');
    }
}
