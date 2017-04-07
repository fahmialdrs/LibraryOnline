<?php

use Illuminate\Database\Seeder;
use App\Author;
use App\Book;
use App\BorrowLog;
use App\User;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//sample author
		$author1 = Author::create(['name'=>'Fahmi Alaydrus']);
		$author2 = Author::create(['name'=>'Irfan Alaydrus']);
		$author3 = Author::create(['name'=>'Abdullah Alaydrus']);

		//sample book
		$book1 = Book::create(['title'=>'Programming Laravel', 'author_id'=>$author1->id, 'amount'=>10]);
		$book2 = Book::create(['title'=>'Nuklir Masa Depan', 'author_id'=>$author2->id, 'amount'=>15]);
		$book3 = Book::create(['title'=>'Ahli Surga', 'author_id'=>$author3->id, 'amount'=>100]);
		$book4 = Book::create(['title'=>'Programming Android', 'author_id'=>$author1->id, 'amount'=>10]);

        $member = User::where('email', 'sm@a.com')->first();
        BorrowLog::create([
            'user_id' => $member->id, 
            'book_id'=> $book1->id, 
            'is_returned'=>0
            ]);
        BorrowLog::create([
            'user_id' => $member->id, 
            'book_id'=> $book2->id, 
            'is_returned'=>0
            ]);
        BorrowLog::create([
            'user_id' => $member->id, 
            'book_id'=> $book3->id, 
            'is_returned'=>1
            ]);
    }
}
