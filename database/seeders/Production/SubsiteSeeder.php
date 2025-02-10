<?php

declare(strict_types=1);

namespace Database\Seeders\Production;

use App\Models\Subsite;
use App\Traits\StringFormattingTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class SubsiteSeeder extends Seeder
{
    use StringFormattingTrait;
    use WithoutModelEvents;

    public function run(): void
    {
        $subsites = config('metafilter.seeders.subsites');

        foreach ($subsites as $key => $subsite) {
            Subsite::firstOrCreate([
                'name' => $subsite['name'],
                'nickname' => $subsite['nickname'] ?? null,
                'logo_filename' => $subsite['logo_filename'] ?? null,
                'white_text' => $subsite['white_text'] ?? null,
                'green_text' => $subsite['green_text'] ?? null,
                'tagline' => $subsite['tagline'] ?? null,
                'slug' => $key,
                'subdomain' => $subsite['subdomain'],
                'route' => $subsite['route'],
                'view' => $subsite['view'],
                'has_theme' => $subsite['has_theme'] ?? false,
                'in_dropdown' => $subsite['in_dropdown'] ?? false,
                'in_footer_nav' => $subsite['in_footer_nav'] ?? false,
                'footer_navigation_sort_order' => $subsite['footer_navigation_sort_order'] ?? 0,
                'global_navigation_sort_order' => $subsite['global_navigation_sort_order'] ?? 0,
            ]);
        }
    }
}
