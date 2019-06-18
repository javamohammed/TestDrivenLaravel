<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        //.\vendor\bin\phpunit --filter a_book_can_be_added_to_the_library
        #$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'a cool book',
            'author' => 'Victor'
        ]);

        $book = Book::first();
        //$response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required(){
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Victor'
        ]);
        $response->assertSessionHasErrors('title');
    }

     /** @test */
    public function a_author_is_required(){
        $response = $this->post('/books',[
            'title' => 'a cool book',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

     /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books',[
            'title' => 'a cool book',
            'author' => 'victor'
        ]);
        $book = Book::first();
        $response = $this->patch('/books/'.$book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);
        $this->assertEquals( 'New Title', Book::first()->title);
        $this->assertEquals( 'New Author', Book::first()->author);
        $response->assertRedirect( $book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        //$this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'a cool book',
            'author' => 'victor'
        ]);
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');

    }
}
