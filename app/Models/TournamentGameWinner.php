<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentGameWinner extends Model
{
    protected $fillable = [
        'tournament_game_id',
        'winners',
    ];

    protected $casts = [
        'winners' => 'array',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(TournamentGame::class, 'tournament_game_id');
    }
}
