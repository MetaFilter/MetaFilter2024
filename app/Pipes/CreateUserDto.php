<?php

declare(strict_types=1);

namespace App\Pipes;

use App\Dtos\UserDto;
use App\Enums\UserStateEnum;
use App\Traits\EmailAddressTrait;
use App\Traits\UrlTrait;
use Closure;

final class CreateUserDto extends BasePipe
{
    use EmailAddressTrait;
    use UrlTrait;

    public function handle(array $data, Closure $next): mixed
    {
        \Log::debug('CreateUserDto::handle()');
        \Log::debug(print_r($data, true));

        $dto = new UserDto(
            id: $data[0],
            name: mb_trim($data[15]) ?? null,
            username: mb_trim($data[1]),
            birthdate: $data[60] ?? null,
            birthdate_year_only: (bool) ($data[61]),
            gender: mb_trim($data[30]) ?? null,
            pronouns: mb_trim($data[88]) ?? null,
            relationship_status: mb_trim($data[70]) ?? null,
            salt: mb_trim($data[4]),
            hashed_password: mb_trim($data[3]),
            email: $this->isValidEmail(mb_trim($data[5])) ? mb_trim($data[5]) : null,
            email_verified_at: $data[51] ?: null,
            show_email: (bool) ($data[7]),
            use_mefi_mail: (bool) ($data[59]),
            paypal_email: $this->isValidEmail($data[6]) ? mb_trim($data[6]) : null,
            homepage_url: mb_trim($data[8]) ? $this->useSecureProtocol(mb_trim($data[8])) : null,
            ip_address: mb_trim($data[22]) ?? null,
            latitude: mb_trim($data[27]) ?? null,
            longitude: mb_trim($data[28]) ?? null,
            nearby: mb_trim($data[68]) ?? null,
            regional: mb_trim($data[85]) ?? null,
            show_coordinates: $data[87] ?? false,
            agrees_to_terms: false,
            is_admin: (bool) ($data[26]),
            is_banned: (bool) ($data[24]),
            show_donate: (bool) ($data[79]),
            show_share_links: !($data[71]),
            created_at: $data[17] ?? null,
            updated_at: $data[37] ?? null,
            deleted_at: $data[89] ?? null,
            user_state: $data[24]
                ? $data['user_state'] ?? UserStateEnum::Banned->value
                : $data['user_state'] ?? UserStateEnum::Active->value,
        );

        \Log::debug(print_r($dto, true));
        $data['dto'] = $dto;

        return $next($data);
    }
}
