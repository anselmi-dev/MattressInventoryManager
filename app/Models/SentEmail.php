<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use jdavidbakr\MailTracker\Concerns\IsSentEmailModel;
use jdavidbakr\MailTracker\Contracts\SentEmailModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentEmail extends Model implements SentEmailModel {

    use IsSentEmailModel;

    protected static $unguarded = true;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'collection',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];
}
