<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
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
        DB::table('authors')->truncate();

        $data = [];
        $createdAt = Carbon::now();

        for ($i=0; $i < 200; $i++) {
            $data[] = [
                'name' => $this->faker->name,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        foreach (array_chunk($data, 1000) as $item) {
            DB::table('authors')->insert($item);
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
