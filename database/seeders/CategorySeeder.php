<?php

namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{

    /**
     * @var Generator
     */
    protected Generator $faker;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();

        $data = [];

        for ($i=0; $i < 200; $i++) {
            $year = fake()->dateTimeBetween(1970)->format('Y');
            $createdAt = fake()->dateTimeBetween($year . '-01-01');

            $data[] = [
                'name' => $this->faker->unique()->sentence(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        foreach (array_chunk($data, 1000) as $item) {
            DB::table('categories')->insert($item);
        }
    }

    /**
     * @return Generator
     * @throws BindingResolutionException
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
