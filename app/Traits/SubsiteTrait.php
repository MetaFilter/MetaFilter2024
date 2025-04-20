<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Subsite;
use Illuminate\Support\Facades\Schema;

trait SubsiteTrait
{
    use LoggingTrait;
    use UrlTrait;

    public function getFullUrl(string $subdomain): string
    {
        $host = config('app.host');

        return $subdomain . $host;
    }

    public function getNewPostText(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => trans('New Question'),
            'irl' => trans('New Event'),
            'projects' => trans('Add Project'),
            default => trans('New Post'),
        };
    }

    public function getEditPostText(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => trans('Edit Question'),
            'irl' => trans('Edit Event'),
            'projects' => trans('Edit Project'),
            default => trans('Edit Post'),
        };
    }

    public function getPreviewPostText(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => trans('Preview Question'),
            'irl' => trans('Preview Event'),
            'projects' => trans('Preview Project'),
            default => trans('Preview Post'),
        };
    }

    public function getSubdomain(): string
    {
        $currentUrl = url()->current();
        $urlParts = parse_url($currentUrl);
        $host = $urlParts['host'];

        $baseDomain = '.' . config('app.host');
        $subdomain = str_replace($baseDomain, '', $host);

        if ($subdomain === 'metafilter') {
            return 'www';
        }

        return $subdomain;
    }

    public function getSubsiteFromUrl(): ?Subsite
    {
        $subdomain = $this->getSubdomain();

        return $this->getSubsiteBySubdomain($subdomain);
    }

    public function getSubsiteBySubdomain(string $subdomain): ?Subsite
    {
        if (
            $subdomain === 'localhost' ||
            $subdomain === 'metafilter' ||
            $subdomain === 'metafilter.test' ||
            $subdomain === 'metastaging.net'
        ) {
            $subdomain = 'www';
        }
        \Log::info('Subdomain: ' . $subdomain);
        if (Schema::hasTable('subsites')) {
            return (new Subsite())->where(column: 'subdomain', operator: '=', value: $subdomain)->first();
        }

        return new Subsite();
    }

    public function getSubsiteId(): int
    {
        $subdomain = $this->getSubdomain();

        return Subsite::where(column: 'subdomain', operator: '=', value: $subdomain)->value('id');
    }

    public function getSubsiteRoute(string $subdomain): string
    {
        return match ($subdomain) {
            'chat' => 'chat.home.index',
            'labs' => 'labs.home.index',
            'mall' => 'mall.home.index',
            'www' => 'metafilter.posts.index',
            default => "$subdomain.posts.index",
        };
    }

    public function getStylesheetName(): string
    {
        $subdomain = $this->getSubdomain();

        if ($subdomain === 'www') {
            return 'metafilter';
        }

        return $subdomain;
    }

    public function getNewPostRouteName(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => 'ask.posts.create',
            'fanfare' => 'fanfare.posts.create',
            'irl' => 'irl.posts.create',
            'metatalk' => 'metatalk.posts.create',
            'music' => 'music.posts.create',
            'podcast' => 'podcast.posts.create',
            'projects' => 'projects.posts.create',
            default => 'metafilter.posts.create',
        };
    }

    public function getPostIndexRouteName(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => 'ask.posts.index',
            'fanfare' => 'fanfare.posts.index',
            'irl' => 'irl.posts.index',
            'metatalk' => 'metatalk.posts.index',
            'music' => 'music.posts.index',
            'podcast' => 'podcast.posts.index',
            'projects' => 'projects.posts.index',
            default => 'metafilter.posts.index',
        };
    }

    public function getShowPostRouteName(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => 'ask.posts.show',
            'fanfare' => 'fanfare.posts.show',
            'irl' => 'irl.posts.show',
            'metatalk' => 'metatalk.posts.show',
            'music' => 'music.posts.show',
            'podcast' => 'podcast.posts.show',
            'projects' => 'projects.posts.show',
            default => 'metafilter.posts.show',
        };
    }

    public function getStorePostRouteName(): string
    {
        $subdomain = $this->getSubdomain();

        return match ($subdomain) {
            'ask' => 'ask.posts.store',
            'fanfare' => 'fanfare.posts.store',
            'irl' => 'irl.posts.store',
            'metatalk' => 'metatalk.posts.store',
            'music' => 'music.posts.store',
            'podcast' => 'podcast.posts.store',
            'projects' => 'projects.posts.store',
            default => 'metafilter.posts.store',
        };
    }
}
