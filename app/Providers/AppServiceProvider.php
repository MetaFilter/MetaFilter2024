<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\RouteNameEnum;
use App\Traits\LoggingTrait;
use App\Traits\SubsiteTrait;
use App\Traits\UrlTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class AppServiceProvider extends ServiceProvider
{
    use LoggingTrait;
    use SubsiteTrait;
    use UrlTrait;

    private const string DEFAULT_COLOR_SCHEME = 'light';

    public function boot(): void
    {
        try {
            $sessionLocale = session()->get('locale') ?? null;

            if (!is_null($sessionLocale)) {
                app()->setLocale($sessionLocale);
            }
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $exception) {
            $this->logError($exception);
        }

        Model::shouldBeStrict();

        Relation::morphMap([
            'posts' => 'App\Models\Post',
            'users' => 'App\Models\User',
        ]);

        $subdomain = $this->getSubdomain();
        
        // Skip subsite lookup during database migration in case we're setting up the
        // schema and the subsites table does not exist yet.
        if ($this->app->runningInConsole() && 
            in_array(
                $_SERVER['argv'][1] ?? null,
                ['migrate', 'migrate:fresh', 'migrate:refresh', 'migrate:reset', 'migrate:rollback']
            )
        ) {
            $subsite = null;
        } else {
            $subsite = $this->getSubsiteBySubdomain($subdomain);
        }

        session([
            'subsite' => $subsite,
            'subsiteHasTheme' => $subsite->has_theme ?? null,
            'subsiteName' => $subsite->name ?? null,
        ]);

        view()->share([
            'appLocale' => app()->getLocale(),
            'contactMessageRoute' => RouteNameEnum::ContactMessageCreate,
            'defaultColorScheme' => self::DEFAULT_COLOR_SCHEME,
            'forgotPasswordRoute' => RouteNameEnum::AuthForgotPasswordCreate,
            'fundingIndexRoute' => RouteNameEnum::MetaFilterFundingIndex,
            'metaFilterPostIndexRoute' => RouteNameEnum::MetaFilterPostIndex->value,
            'loginCreateRoute' => RouteNameEnum::AuthLoginCreate,
            'logoutRoute' => RouteNameEnum::AuthLogout,
            'preferencesEditRoute' => RouteNameEnum::PreferencesEdit,
            'memberEditRoute' => RouteNameEnum::MemberEdit,
            'memberShowRoute' => RouteNameEnum::MemberShow,
            'signupCreateRoute' => RouteNameEnum::SignupCreate,
            'signupThanksRoute' => RouteNameEnum::SignupThanks,
            'signupWizardRoute' => RouteNameEnum::SignupWizard,
            'subdomain' => $subdomain === 'www' ? 'metafilter' : $subdomain,
            'subsite' => $subsite,
            'subsiteHasTheme' => $subsite->has_theme ?? null,
            'subsiteName' => $subsite->name ?? null,
            'greenText' => $subsite->green_text ?? null,
            'whiteText' => $subsite->white_text ?? null,
            'tagline' => $subsite->tagline ?? null,
        ]);
    }
}
