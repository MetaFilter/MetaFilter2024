<?php

declare(strict_types=1);

namespace App\Models;

use App\Presenters\UserPresenter;
use App\States\User\UserState;
use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
use Cog\Contracts\Ban\Bannable as BannableInterface;
use Cog\Laravel\Ban\Traits\Bannable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Overtrue\LaravelVote\Traits\Voter;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property bool $agrees_to_terms
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $hashed_password
 * @property string $homepage_url
 * @property int $legacy_id
 * @property string $email
 * @property bool $show_email
 * @property bool $use_mefi_mail
 * @property string $blurb
 * @property string $blurb_max
 * @property string $ip_address
 * @property string $latitude
 * @property string $longitude
 * @property string $location
 * @property string $gender
 * @property string $relationship_status
 * @property string $pronouns
 * @property bool $is_admin
 * @property string $email_verified_at
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $state
 *
 * @mixin Builder
 */
final class User extends Authenticatable implements
    BannableInterface,
    CanPresent,
    FilamentUser,
    HasMedia,
    HasName
{
    use Bannable;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasStates;
    use InteractsWithMedia;
    use Notifiable;
    use SoftDeletes;
    use UsesPresenters;
    use Voter;

    // Properties

    protected $fillable = [
        'agrees_to_terms',
        'name',
        'username',
        'password',
        'salt',
        'hashed_password',
        'homepage_url',
        'legacy_id',
        'email',
        'show_email',
        'use_mefi_mail',
        'blurb',
        'blurb_max',
        'ip_address',
        'latitude',
        'longitude',
        'location',
        'gender',
        'relationship_status',
        'pronouns',
        'is_admin',
        'state',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected array $presenters = [
        'default' => UserPresenter::class,
    ];

    protected array $searchable = [
        'username',
        'blurb',
        'blurb_max',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'state' => UserState::class,
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function toSearchableArray(): array
    {
        return ['id' => (string) $this->id] + $this->toArray();
    }

    // Builders
    /*
        public function newEloquentBuilder($query): UserQueryBuilder
        {
            return new UserQueryBuilder($query);
        }
    */
    // Relationships

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function passkeys(): HasMany
    {
        return $this->hasMany(Passkey::class);
    }

    public function getFilamentName(): string
    {
        return $this->username;
    }
}
