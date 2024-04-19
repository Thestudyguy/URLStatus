<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlEmail extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'url_id'];
    public function UrlEmail() : BelongsTo{
        return $this->belongsTo(Urlcs::class, 'url_id');
    }
}
