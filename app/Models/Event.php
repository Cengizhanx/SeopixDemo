<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    
    protected $fillable = ['title', 'start_time', 'finish_time', 'user_id','content','status'];

    protected $casts = [
        'start_time' => 'datetime',
        'finish_time' => 'datetime',
    ];
    public function positions()
    {
        return $this->hasMany(EventPosition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
