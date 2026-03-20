<?php

namespace Bibrkacity\SanctumSession\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for variables related to PersonalAccessToken of the Sanctum
 */
class PersonalAccessTokenVar extends Model
{
    protected $fillable = [
        'personal_access_token_id',
        'key',
        'type',
        'value',
    ];
}
