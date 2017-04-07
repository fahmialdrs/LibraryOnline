<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


class Author extends Model
{
    protected $fillable = ['name'];

    public function books() {
    	return $this->hasMany('App\Book');
    }

    public static function boot() {
    	parent::boot();

    	self::deleting(function($author) {
    		// check author relation with books

    		if ($author->books->count()>0) {
    			// error notif
    			$html = "<b> $author->name </b>still has books relation :";
    			$html .= '<ul>';
    			foreach ($author->books as $book) {
    				$html .= "<li>$book->title</li>"; 
    			}
    			$html .= '</ul>';

    			Session::flash("flash_notification", [
    				"level" => "danger",
    				"message" => $html
    				]);
    			return false;
    		}
    	});
    }
}
