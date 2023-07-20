<?php

namespace Database\Factories;

use App\Enums\Lang;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
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
        $year = fake()->dateTimeBetween(1970)->format('Y');
        $createdAt = fake()->dateTimeBetween($year . '-01-01');

        return [
            'name' => $this->faker->unique()->sentence(),
            'year' => $year,
            'created_at' => $createdAt,
            'lang' => $this->faker->randomElement(Lang::class),
            'pages' => fake()->numberBetween(10, 55000),
            'category_id' => $this->faker->numberBetween(1, 200),
        ];
    }
}
