<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Author;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        //.\vendor\bin\phpunit --filter a_book_can_be_added_to_the_library
        #$this->withoutExceptionHandling();
        $response = $this->post('/books', $this->data());

        $book = Book::first();
        //$response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required(){
        $response = $this->post('/books', array_merge($this->data(), ['title' => '']));
        $response->assertSessionHasErrors('title');
    }

     /** @test */
    public function a_author_is_required(){
        $response = $this->post('/books',array_merge( $this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }

     /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books',$this->data());
        $book = Book::first();
        $response = $this->patch('/books/'.$book->id, [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);
        $this->assertEquals( 'New Title', Book::first()->title);
        $this->assertEquals( 2, Book::first()->author_id);
        $response->assertRedirect( $book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        //$this->withoutExceptionHandling();
        $this->post('/books', $this->data());
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');

    }
    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();
        $this->assertEquals($book->author_id, $author->id);
        $this->assertCount(1, Author::all());
    }
    private function data(){
        return [
            'title' => 'a cool book',
            'author_id' => 'Victor'
        ];
    }

}
