<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Flavio'
        ]);
        $response->assertOk();

        $this->assertCount(1, Book::all());
    }
    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Flavio Silva'
        ]);
        $response->assertSessionHasErrors(['title']);

    }

    /** @test */

    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Testing',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'old book',
            'author' => 'old author'
        ]);
        $book = Book::query()->first();

        $response = $this->patch("/books/{$book->id}", [
            'title' => 'new book',
            'author' => 'new author'
        ]);

        $book = Book::query()->first();
        $this->assertEquals('new book', $book->title);
        $this->assertEquals('new author', $book->author);

    }
}
