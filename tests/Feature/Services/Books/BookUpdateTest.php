<?php

namespace Feature\Services\Books;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    private Model $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->book = Book::query()->first();
    }

    /**
     * @dataProvider dataSuccessUpdate
     * A basic feature test example.
     */
    public function testSuccessfulUpdate(array $data): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->putJson('/api/v1/books/' . $this->book->id, $data);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('data.name', $data['name'])
                ->where('data.year', $data['year'])
                ->where('data.lang', $data['lang'])
                ->where('data.pages', $data['pages'])
                ->where('data.category.id', $data['categoryId'])
                ->etc())
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'year',
                    'category' => [
                        'id',
                        'name',
                    ],
                    'lang',
                    'pages',
                    'createdAt',
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'name'          => $data['name'],
            'year'          => $data['year'],
            'lang'          => $data['lang'],
            'pages'         => $data['pages'],
            'category_id'   => $data['categoryId'],
        ]);
    }

    /**
     * @dataProvider dataFailedUpdate
     * @param array $data
     * @param string $errorMessage
     * @param string $field
     * @return void
     */
    public function testFailedUpdate(array $data, string $errorMessage, string $field)
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->putJson('/api/v1/books/' . $this->book->id, $data);

        $response->assertStatus(422)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('errors.' . $field . '.0', $errorMessage)
                ->etc())
            ->assertJsonStructure([
                'message',
                'errors' => [
                    $field
                ],
            ]);
    }

    public static function dataSuccessUpdate(): array
    {
        $currentYear = (int)Carbon::now()->format('Y');
        $randomizerAlpha = rand(100, 999);
        $letters = chr(rand(65, 90)) . chr(rand(65, 90));

        return [
            'min values' => [
                [
                    'name'          => $letters,
                    'year'          => 1970,
                    'lang'          => 'en',
                    'pages'         => 10,
                    'categoryId'    => 5,
                ],
            ],

            'max values' => [
                [
                    'name'          => 'asdfasdfasdfsadf asfd asdf asdf sadfasdf as fas dfsadf asd fasdf ' .
                                       'asdf asd fasd fasdf as dfasd fsad fsadf asd fasd fsad fasdf sadf ' .
                                       'sad fasdf asd fasd fasd fsad fsad fawertert ert wer twet t wert ' .
                                       'ssgsdfgds fg sdfg ser reth d22g sdgegsdgsdfger 6456  dsfgg' .
                                       $randomizerAlpha,
                    'year'          => $currentYear,
                    'lang'          => 'ua',
                    'pages'         => 55000,
                    'categoryId'    => 5,
                ],
            ]
        ];
    }

    public static function dataFailedUpdate(): array
    {
        $nextYear = (int)Carbon::now()->addYear()->format('Y');

        return [
            'name is too long' => [
                [
                    'name'          => 'asdfasdfasdfsadf asfd asdf asdf sadfasdf as fas dfsadf asd fasdf ' .
                                       'asdf asd fasd fasdf as dfasd fsad fsadf asd fasd fsad fasdf sadf ' .
                                       'sad fasdf asd fasd fasd fsad fsad fawertert ert wer twet t wert ' .
                                       'ssgsdfgds fg sdfg ser reth dfhg sdgegsdgsdfger 6456  dsfggds g',
                    'year'          => 1990,
                    'lang'          => 'ua',
                    'pages'         => 1234,
                    'categoryId'    => 5,
                ],
                'The name field must not be greater than 255 characters.',
                'name',

            ],

            'year equal or greater then 1970' => [
                [
                    'name'          => 'test132226',
                    'year'          => 1969,
                    'lang'          => 'ua',
                    'pages'         => 1234,
                    'categoryId'    => 5,
                ],
                'The year field must be at least 1970.',
                'year',
            ],

            'year equal or smaller then actual year' => [
                [
                    'name'          => 'test132226',
                    'year'          => $nextYear,
                    'lang'          => 'ua',
                    'pages'         => 1234,
                    'categoryId'    => 5,
                ],
                'The year field must not be greater than 2023.',
                'year',
            ],

            'pages must equal or greater then 10' => [
                [
                    'name'          => 'test132226',
                    'year'          => 1980,
                    'lang'          => 'ua',
                    'pages'         => 9,
                    'categoryId'    => 5,
                ],
                'The pages field must be at least 10.',
                'pages',
            ],

            'pages must equal or smaller then 55000' => [
                [
                    'name'          => 'test132226',
                    'year'          => 1980,
                    'lang'          => 'ua',
                    'pages'         => 55001,
                    'categoryId'    => 5,
                ],
                'The pages field must not be greater than 55000.',
                'pages',
            ],
        ];
    }
}
