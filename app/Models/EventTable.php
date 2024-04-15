<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTable extends Model
{
    use HasFactory;
    protected $fillable = ['EventURL', 'EventStatusCode'];
}
