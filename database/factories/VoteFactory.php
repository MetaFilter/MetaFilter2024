<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

final class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        return [
            'idea_id' => (new Idea)->inRandomOrder()->first(),
            'user_id' => (new User)->inRandomOrder()->first(),
        ];
    }
}
