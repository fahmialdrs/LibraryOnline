<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Facades\Datatables;
use App\BorrowLog;


class StatisticsController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder) {
    	if($request->ajax()) {
    		$stats = BorrowLog::with('book','user');
    		if($request->get('status') == 'returned') $stats->returned();
    		if($request->get('status') == 'not-returned') $stats->borrowed();

    		return Datatables::of($stats)
    		->addColumn('returned_at', function($stat) {
    			if($stat->is_returned){
    				return $stat->updated_at;
    			}
    			return "still borrowed books";
    		})->make(true);
    	}

    	$html = $htmlBuilder
    	->addColumn(['data'=>'book.title', 'name' => 'book.title', 'title' => 'Title'])
    	->addColumn(['data'=>'user.name', 'name' => 'user.name', 'title' => 'Borrower'])
    	->addColumn(['data'=>'created_at', 'name' => 'created_at', 'title' => 'Borrowed Date', 'searchable' => false])
    	->addColumn(['data'=>'returned_at', 'name' => 'returned_at', 'title' => 'Returned Date', 'searchable' => false, 'orderable'=>false]);

    	return view('statistics.index')->with(compact('html'));
    }
}
