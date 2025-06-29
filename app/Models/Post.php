<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PostStateEnum;
use App\Presenters\PostPresenter;
use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Maize\Markable\Markable;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Favorite;
use Mpociot\Versionable\VersionableTrait;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string $more_inside
 * @property int $legacy_id
 * @property int $subsite_id
 * @property int $user_id
 * @property string $published_at
 * @property bool $is_archived
 * @property bool $is_published
 * @property string $state
 */
final class Post extends BaseModel implements CanPresent, HasMedia
{
    use HasDrafts;
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    use LogsActivity;
    use Markable;
    use Searchable;
    use Sluggable;
    use SoftDeletes;
    use UsesPresenters;
    use VersionableTrait;

    protected const int DAYS_UNTIL_ARCHIVED = 30;
    protected const array PREVIOUS_NEXT_COLUMNS = [
        'id',
        'slug',
        'title',
    ];

    // Properties

    protected $fillable = [
        'title',
        'body',
        'more_inside',
        'legacy_id',
        'subsite_id',
        'user_id',
        'published_at',
        'is_published',
        'slug',
        'is_current',
        'publisher_type',
        'publisher_id',
    ];

    protected static array $marks = [
        Bookmark::class,
        Favorite::class,
        Flag::class,
    ];

    protected array $presenters = [
        'default' => PostPresenter::class,
    ];

    protected $attributes = [
        'state' => PostStateEnum::Draft->value,
    ];

    public function toSearchableArray(): array
    {
        return array_merge($this->toArray(), [
            'id' => (string) $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'more_inside' => $this->more_inside,
            'created_at' => $this->created_at,
        ]);
    }

    protected array $searchable = [
        'title',
        'body',
        'more_inside',
    ];

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    protected function isArchived(): Attribute
    {
        $archiveDate = now()->subDays(self::DAYS_UNTIL_ARCHIVED);

        return Attribute::make(
            get: fn($value) => $this->created_at <= $archiveDate,
        );
    }

    public function sluggable(): array
    {
        return $this->getSlugFrom('title');
    }

    // Builders

    /*
        public function newEloquentBuilder($query): PostQueryBuilder
        {
            return new PostQueryBuilder($query);
        }
    */
    // Relationships

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

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

    public function next(): Post|null
    {
        return $this->select(self::PREVIOUS_NEXT_COLUMNS)
            ->where('id', '>', $this->id)
            ->where('subsite_id', '=', $this->subsite_id)
            ->orderBy('id')
            ->first();
    }

    public function previous(): Post|null
    {
        return $this->select(self::PREVIOUS_NEXT_COLUMNS)
            ->where('id', '<', $this->id)
            ->where('subsite_id', '=', $this->subsite_id)
            ->orderByDesc('id')
            ->first();
    }

    public function subsite(): BelongsTo
    {
        return $this->belongsTo(Subsite::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
