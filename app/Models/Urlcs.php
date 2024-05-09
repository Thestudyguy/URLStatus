<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Urlcs extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'status', 'owner'];
    //public function URL() : HasMany{
    //    return $this->hasMany(Emails::class, 'url');
    //}
    //public function URLhistory() : HasMany{
    //    return $this->hasMany(urlhistory::class, 'url_ref');
    //}
    
}
