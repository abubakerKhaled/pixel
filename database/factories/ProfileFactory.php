<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $handle = $this->faker->unique()->userName();
        $bgColor = $this->faker->hexColor();
        $textColor = $this->faker->hexColor();

        return [
            'user_id' => User::factory(),
            'display_name' => $this->faker->name(),
            'handle' => $handle,
            'bio' => $this->faker->sentence(3, true),
            'avatar_url' => 'https://dummyimage.com/640x480/'.ltrim($bgColor, '#').'/'.ltrim($textColor, '#'),
            'cover_url' => "https://dummyimage.com/1400x640/333/f76a00?text={$handle}",
        ];
    }
}
