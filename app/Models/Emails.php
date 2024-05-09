<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

class Emails extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'url', 'owner'];
    public function Email() : BelongsTo{
        return $this->belongsTo(URL::class, 'url');
    }
}
