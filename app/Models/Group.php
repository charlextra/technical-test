<?php

namespace App\Models;


use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * Class Group.
 *
 * @property int $id
 * @property string $title
 * @property int $company_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Company $company
 * @property Collection|User[] $users
 * @property Collection|GroupUser[] $group_users
 *
 * @mixin Eloquent
 */
class Group extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The field to use in log activity as model title.
     *
     * @var string
     */
    protected $asTitle = 'title';

    /**
     * Get the users of the group.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id')
            ->using(GroupUser::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    /**
     * Get the group users.
     *
     * @return HasMany
     */
    public function group_users(): HasMany
    {
        return $this->hasMany(GroupUser::class);
    }
}
