<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'slug' => Str::slug(fake()->company()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
