<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class IdeaFactory extends Factory
{
    protected $model = Idea::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
//            'status_id' => Status::factory(),
            'title' => ucwords($this->faker->words(4, true)),
            'description' => $this->faker->paragraph(5),
        ];
    }

    public function existing(): IdeaFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => $this->faker->numberBetween(1, 20),
                'category_id' => $this->faker->numberBetween(1, 4),
//                'status_id' => $this->faker->numberBetween(1, 5),
            ];
        });
    }
}
