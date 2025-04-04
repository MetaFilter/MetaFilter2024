<?php

declare(strict_types=1);

namespace App\Pipes;

use App\Models\User;
use Closure;

final class CreateUser extends BasePipe
{
    public function handle(array $data, Closure $next): Closure
    {
        \Log::debug('CreateUser::handle()');
        $dto = $data['dto'];

        $user = new User();

        $user->agrees_to_terms = $dto->agrees_to_terms;
        $user->name = $dto->name;
        $user->username = $dto->username;
        $user->password = $dto->password;
        $user->salt = $dto->salt;
        $user->hashed_password = $dto->hashed_password;
        $user->homepage_url = $dto->homepage_url;
        $user->email = $dto->email;
        $user->show_email = $dto->show_email;
        $user->use_mefi_mail = $dto->use_mefi_mail;
        $user->blurb = $dto->blurb;
        $user->blurb_max = $dto->blurb_max;
        $user->ip_address = $dto->ip_address;
        $user->latitude = $dto->latitude;
        $user->longitude = $dto->longitude;
        $user->nearby = $dto->nearby;
        $user->regional = $dto->regional;

        $user->save();

        $data['user'] = $user;
        \Log::debug(print_r($user, true));

        return $next($data);
    }
}
/*
 *         'id',
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

 */
