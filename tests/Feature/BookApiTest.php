<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_books()
    {
        $user = User::factory()->create();
        Book::factory()->count(3)->create();

        $response = $this->actingAs($user)->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'data' => [['id', 'title', 'author', 'isbn']],
                 ]);
    }

    public function test_user_can_create_book()
    {
        $user = User::factory()->create();

        $data = [
            'title' => 'New Book',
            'author' => 'Author Name',
            'isbn' => '1234567890123',
        ];

        $response = $this->actingAs($user)->postJson('/api/books', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'New Book']);
    }
}
