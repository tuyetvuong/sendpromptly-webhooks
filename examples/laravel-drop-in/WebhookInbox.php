<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookInbox extends Model
{
    protected $table = 'webhook_inbox';
    protected $guarded = [];
    protected $casts = [
        'payload' => 'array',
        'timestamp' => 'integer',
        'processed_at' => 'datetime',
    ];
}
