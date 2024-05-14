<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class urlhistory extends Model
{
    use HasFactory;
    protected $fillable = ['url', 'status', 'old_status', 'new_status', 'url_id'];
    public function url() : BelongsTo{
        return $this->belongsTo(urlhistory::class, 'url');
    }
}
