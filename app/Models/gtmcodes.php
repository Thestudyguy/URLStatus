<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class gtmcodes extends Model
{
    use HasFactory;
    protected $fillable = ['gtm_codes', 'url'];
    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class, 'url');
    }
}
