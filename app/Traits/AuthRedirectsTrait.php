<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\RouteNameEnum;
use Illuminate\Http\RedirectResponse;

trait AuthRedirectsTrait
{
    public function redirectToLogin(): RedirectResponse
    {
        redirect()->setIntendedUrl(url()->previous());

        return redirect()->route(RouteNameEnum::AuthLoginCreate->value);
    }

    public function redirectToRegister(): RedirectResponse
    {
        redirect()->setIntendedUrl(url()->previous());

        return redirect()->route(RouteNameEnum::SignupCreate->value);
    }
}
