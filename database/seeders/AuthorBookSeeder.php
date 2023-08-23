<?php

namespace Database\Seeders;

use App\Enums\Lang;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorBookSeeder extends Seeder
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
        DB::table('author_book')->truncate();

        $total = 1200000;
        $batchSize = 1000;

        for ($i=0; $i < $total; $i+= $batchSize) {
            $data = [];

            for ($l=0; $l < $batchSize; $l++) {
                $data[] = [
                    'author_id' => $this->faker->numberBetween(1, 200),
                    'book_id'   => $this->faker->numberBetween(1, 1200000),
                ];
            }

            DB::table('author_book')->insert($data);
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
