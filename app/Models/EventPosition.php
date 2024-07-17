<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPosition extends Model
{
    protected $fillable = ['event_id', 'position'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_positions');
    }
}
