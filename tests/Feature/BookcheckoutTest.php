<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
use App\User;
use App\Reservation;

class BookcheckoutTest extends TestCase
{
    use RefreshDatabase;
   /**
    * @test
    */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {
        $this->withoutExceptionHandling();
        $book= factory(Book::class)->create();
        $this->actingAs($user = factory(User::class)->create())->post('/checkout/'.$book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

    /**
     * @test
     */
    public function only_signed_in_users_can_checkout_a_book()
    {

        $book = factory(Book::class)->create();
        $this->post('/checkout/' . $book->id)->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }
     /**
     * @test
     */
    public function only_real_books_can_be_checked_out()
    {

        $book = factory(Book::class)->create();
        $this->actingAs(factory(User::class)->create())->post('/checkout/123')->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }

    /**
     * @test
     */
    public function a_book_can_be_checked_in_by_a_signed_in_user()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $this->actingAs( $user)->post('/checkout/' . $book->id);
        $this->actingAs($user)->post('/checkin/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

}
