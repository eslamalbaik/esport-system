<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Winner extends Model
{
    protected $fillable = [
        'tournament_card_id',
        'kind',
        'single_registration_id',
        'team_registration_id',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'array',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(TournamentCard::class, 'tournament_card_id');
    }

    public function singleRegistration(): BelongsTo
    {
        return $this->belongsTo(SingleRegistration::class);
    }

    public function teamRegistration(): BelongsTo
    {
        return $this->belongsTo(TeamRegistration::class);
    }
}
