<?php

namespace Tests\Feature\Services\Books;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookIndexTest extends TestCase
{
    /**
     * @dataProvider dataSuccessIndex
     * A basic feature test example.
     */
    public function testSuccessfulIndex(array $data): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson($data['url']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
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
                    ]
                ],
            ]);
    }

    /**
     * @dataProvider dataFailedIndex
     * @param array $data
     * @param string $errorMessage
     * @param string $field
     * @return void
     */
    public function testFailedIndex(array $data, string $errorMessage, string $field): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson($data['url']);

        $response->assertStatus(422)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('errors.' . $field . '.0', $errorMessage)
                ->etc());
    }

    public static function dataSuccessIndex(): array
    {
        $today = Carbon::now()->format('Y-m-d');

        return [
            'query by created_at' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today
                ]
            ],

            'query by created_at and lastId' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&lastId=5'
                ]
            ],

            'query by created_at and lang' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&lang=en'
                ]
            ],

            'query by created_at, lang and lastId' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&lang=en&lastId=5'
                ]
            ],

            'query by created_at and year' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&year=1990'
                ]
            ],

            'query by created_at, year and lastId' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&year=1990&lastId=5'
                ]
            ],

            'query by created_at, lang and year' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&lang=en&year=1990'
                ]
            ],

            'query by created_at, lang, year and lastId' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=' . $today . '&lang=en&year=1990&lastId=5'
                ]
            ],
        ];
    }

    public static function dataFailedIndex(): array
    {
        $today = Carbon::now()->format('Y-m-d');
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');
        $nextYear = Carbon::now()->addYear()->format('Y');

        return [
            'startDate: after or equal' => [
                [
                    'url' => '/api/v1/books?startDate=1969-01-01&endDate=1990-01-01',
                ],
                'The start date field must be a date after or equal to 1970-01-01.',
                'startDate',
            ],

            'startDate: before or equal' => [
                [
                    'url' => '/api/v1/books?startDate=2002-05-23&endDate=2002-05-21',
                ],
                'The start date field must be a date before or equal to end date.',
                'startDate',
            ],

            'endDate: required' => [
                [
                    'url' => '/api/v1/books?startDate=2002-05-23',
                ],
                'The end date field is required.',
                'endDate',
            ],

            'endDate: after:startDate' => [
                [
                    'url' => '/api/v1/books?endDate=1970-01-01',
                ],
                'The end date field must be a date after start date.',
                'endDate',
            ],

            'endDate: before or equal' => [
                [
                    'url' => '/api/v1/books?startDate=1990-01-01&endDate=' . $tomorrow,
                ],
                'The end date field must be a date before or equal to ' . $today . '.',
                'endDate',
            ],

            'year: integer' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=1990-01-01&year=sdfs',
                ],
                'The year field must be an integer.',
                'year',
            ],

            'year: min:1970' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=1990-01-01&year=1969',
                ],
                'The year field must be at least 1970.',
                'year',
            ],

            'year: max:actual year' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=1990-01-01&year=' . $nextYear,
                ],
                'The year field must not be greater than 2023.',
                'year',
            ],

            'lastId: integer' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=1990-01-01&lastId=sdsf',
                ],
                'The last id field must be an integer.',
                'lastId',
            ],

            'lastId: min:1' => [
                [
                    'url' => '/api/v1/books?startDate=1970-01-01&endDate=1990-01-01&lastId=-1',
                ],
                'The last id field must be at least 1.',
                'lastId',
            ],
        ];
    }
}
