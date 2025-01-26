<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $idea_id
 * @property int $user_id
 */
final class Vote extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    // Properties

    protected $fillable = [
        'idea_id',
        'user_id',
    ];

    // Relationships

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
