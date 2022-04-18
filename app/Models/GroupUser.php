<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class GroupUser.
 *
 * @property int $id
 * @property int $group_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property \App\Group $group
 * @property \App\User $user
 */
class GroupUser extends Pivot
{

    /** @var string */
    protected $table = 'group_user';

    /** @var string[] */
    protected $casts = [
        'group_id' => 'int',
        'user_id' => 'int',
    ];

    /** @var string[] */
    protected $fillable = [
        'group_id',
        'user_id',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(\App\Group::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

}
