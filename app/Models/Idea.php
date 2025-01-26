<?php

declare(strict_types=1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $spam_reports
 * @property int $category_id
 * @property int $user_id
 */
final class Idea extends BaseModel
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    // Properties

    protected $fillable = [
        'title',
        'description',
        'spam_reports',
        'category_id',
        'user_id',
    ];

    public function sluggable(): array
    {
        return $this->getSlugFrom('title');
    }

    // Relationships

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function isVotedByUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return (new Vote)
            ->where('user_id', '=', $user->id)
            ->where('idea_id', '=', $this->id)
            ->exists();
    }
}
