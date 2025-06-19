<?php

declare(strict_types=1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 */
final class Snippet extends BaseModel
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    // Properties

    protected $fillable = [
        // TODO: Should it be possible to target a specific subsite?
        'title',
        'body',
    ];

    public function sluggable(): array
    {
        return $this->getSlugFrom('title');
    }
}
