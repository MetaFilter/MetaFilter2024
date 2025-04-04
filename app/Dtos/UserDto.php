<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Enums\UserStateEnum;

readonly class UserDto
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public string $username,
        public ?string $birthdate,
        public bool $birthdate_year_only,
        public ?string $gender,
        public ?string $pronouns,
        public ?string $relationship_status,
        public string $salt,
        public string $hashed_password,
        public string $email,
        public ?string $email_verified_at,
        public bool $show_email,
        public bool $use_mefi_mail,
        public ?string $paypal_email,
        public ?string $homepage_url,
        public string $ip_address,
        public ?string $latitude,
        public ?string $longitude,
        public ?int $nearby,
        public ?int $regional,
        public bool $show_coordinates,
        public bool $agrees_to_terms,
        public bool $is_admin,
        public bool $is_banned,
        public bool $show_donate,
        public bool $show_share_links,
        public string $created_at,
        public ?string $updated_at,
        public ?string $deleted_at,
        public UserStateEnum $user_state,
    ) {}
}
