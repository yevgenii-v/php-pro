<?php

namespace Tests\Feature\Services\Books;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class BookDestroyTest extends TestCase
{
    protected Model $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->book = Book::query()->first();
    }

    /**
     * A basic feature test example.
     */
    public function testSuccessfulDestroy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->deleteJson('/api/v1/books/' . $this->book->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', [
            'name' => $this->book->name,
        ]);
    }
}
