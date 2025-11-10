<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
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
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'genre' => $this->faker->randomElement(['Fantastika', 'Mokslinė fantastika', 'Detektyvas', 'Trileris', 'Romanas']),
            'release_date' => $this->faker->date(),
            'book_description' => $this->faker->paragraph(5),
            'page_count' => $this->faker->numberBetween(100, 1000),
            'book_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
