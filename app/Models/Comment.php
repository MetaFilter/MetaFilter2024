<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Maize\Markable\Markable;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Favorite;
use Mpociot\Versionable\VersionableTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property string $body
 * @property int $parent_id
 * @property int $post_id
 * @property int $user_id
 * @property User $user
 */
final class Comment extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use Markable;
    use Searchable;
    use SoftDeletes;
    use VersionableTrait;

    // Properties

    protected $fillable = [
        'body',
        'parent_id',
        'post_id',
        'user_id',
    ];

    protected static array $marks = [
        Bookmark::class,
        Favorite::class,
        Flag::class,
    ];

    protected array $searchable = [
        'text',
    ];

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function toSearchableArray(): array
    {
        return array_merge($this->toArray(), [
            'id' => (string) $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->timestamp,
        ]);
    }

    // Builders
    /*
        public function newEloquentBuilder($query): CommentQueryBuilder
        {
            return new CommentQueryBuilder($query);
        }
    */
    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->whereFullText(
            ['body'],
            "$keyword*",
            ['mode' => 'boolean'],
        );
    }

    // Relationships

    public function bookmarkCount(): int
    {
        return Bookmark::count($this);
    }

    public function favoriteCount(): int
    {
        return Favorite::count($this);
    }

    public function flagCount(): int
    {
        return Flag::count($this);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            related: Comment::class,
            foreignKey: 'parent_id',
            ownerKey: 'id',
        );
    }


    public function replies(): HasMany
    {
        return $this->hasMany(
            related: Comment::class,
            foreignKey: 'parent_id',
            localKey: 'id',
        )->with([
            'user',
            'bookmarks',
            'favorites',
            'flags',
        ]);
    }
}
