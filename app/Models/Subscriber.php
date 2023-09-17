<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'events_subscribers', 'subscriber_id', 'event_id');
    }
}
