<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    protected $fillable = [
        'team_registration_id',
        'member_name',
        'member_ingame_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(TeamRegistration::class, 'team_registration_id');
    }
}
