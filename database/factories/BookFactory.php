<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->company(),
            'isbn' => $this->faker->isbn13(),
            'publication_date' => $this->faker->date(),
            'cover_image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(0, 100, 1000),
            'stock' => $this->faker->boolean(),
        ];
    }
}
