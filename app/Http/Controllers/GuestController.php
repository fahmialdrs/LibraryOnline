<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Book;
use Laratrust\LaratrustFacade as Laratrust;

class GuestController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder){
    	if ($request->ajax()) {
    		$book = Book::with('author');
    		return Datatables::of($book)
    		->addColumn('stock', function($books) {
    			return $books->stock;
    		})
    		->addColumn('action', function($books) {
    			if (Laratrust::hasRole('admin')) return '';
    			return '<a class="btn btn-xs btn-primary" href="'.route('guest.book.borrow', $books->id).'">Borrow</a>';
    		})->make(true);
    	}

    	$html = $htmlBuilder
    	->addColumn(['data' => 'title', 'name' => 'title', 'title'=> 'Title'])
    	->addColumn(['data' => 'stock', 'name' => 'stock', 'title' => 'Stock', 'orderable' =>false, 'searchable' => false])
    	->addColumn(['data' => 'author.name', 'name' => 'author.name', 'title'=> 'Authors'])
    	->addColumn(['data' => 'action', 'name' => 'action', 'title'=> '', 'orderable' => false, 'searchable' => false]);

    	return view('guest.index')->with(compact('html'));
    }
}
