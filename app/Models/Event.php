<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class, 'events_subscribers', 'event_id', 'subscriber_id');
    }
}
