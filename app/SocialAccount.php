<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    /**
     * @var array The mass-assignable property
     */
    protected $fillable = [
        'user_id',
        'provider_user_id',
        'provider'
    ];

    /**
     * The user relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
