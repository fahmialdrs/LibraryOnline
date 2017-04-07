<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Book extends Model
{
    protected $fillable = ['title','author_id','amount'];

    public static function boot() {

	    parent::boot();

	    self::updating(function($book){
	    	if ($book->amount < $book->borrowed) {
	    		Session::flash("flash_notification", [
	    			"level" => "danger",
	    			"message" => "Book <b> $book->title </b> Amount must be greater or equals than " . $book->borrowed
	    			]);
	    		return false;
	    	}
	    });

	    self::deleting(function($book) {
	    	if ($book->borrowLogs()->count() > 0) {
	    		Session::flash("flash_notification", [
	    			"level" => "danger",
	    			"message" => "<b> $book->title </b> Already Borrowed"
	    			]);
	    		return false;
	    	}
	    });
	}

	public function getBorrowedAttribute() {
		return $this->borrowLogs()->borrowed()->count();
	}


    public function author() {
    	return $this->belongsTo('App\Author');
    }

    public function borrowLogs() {
    	return $this->hasMany('App\BorrowLog');
    }

    public function getStockAttribute() {
    	$borrowed = $this->borrowLogs()->borrowed()->count();
    	$stock = $this->amount - $borrowed;
    	return $stock;
    }
}
