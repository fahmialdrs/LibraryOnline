<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use Session;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\BorrowLog;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BookException;
use Excel;
use PDF;
use Validator;
use App\Author;



class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $book = Book::with('author');
            return Datatables::of($book)
            ->addColumn('stock', function($books) {
                return $books->stock;
            })
            ->addColumn('action', function($books) {
                return view('datatable._action', [
                    'model'=> $books,
                    'form_url' => route('book.destroy', $books->id),
                    'edit_url' => route('book.edit', $books->id),
                    'confirm_message' => 'Are you sure want to delete ' . $books->title . '?'
                    ]);                
            })->make(true);
        }

        $html = $htmlBuilder
        ->addColumn(['data' => 'title', 'name'=>'title', 'title'=>'Title'])
        ->addColumn(['data' => 'amount', 'name'=>'amount', 'title'=>'Amount'])
        ->addColumn(['data' => 'stock', 'name' => 'stock', 'title' => 'Stock', 'orderable' =>false, 'searchable' => false])
        ->addColumn(['data' => 'author.name', 'name'=>'author.name', 'title'=>'Authors Name'])
        ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'', 'orderable'=>false, 'searchable'=>false]);

        return view('book.index')->with(compact('html'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->except('cover'));

        // isi field cover jika ada cover yg di upload

        if ($request->hasFile('cover')) {
            
            //ambil file yang di upload
            $uploaded_cover = $request->file('cover');

            // ambil extension file
            $extension = $uploaded_cover->getClientOriginalExtension();

            // membuat nama file random
            $filename = md5(time()) . '.' . $extension;

            // simpan file ke folder public/img

            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $uploaded_cover->move($destinationPath, $filename);

            // mengisi field cover di book dengan filename yg baru dibuat
            $book->cover = $filename;
            $book->save();


        }

        Session::flash("flash_notification", [
            "level"=>"success",
            "message" => "Store Book <b> $book->title </b> into Database is Success"
            ]);

        return redirect()->route('book.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return view('book.edit')->with(compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::find($id);
        if (!$book->update($request->all())) return redirect()->back();

        // isi field cover jika ada cover yg di upload

        if ($request->hasFile('cover')) {
            
            //ambil file yang di upload
            $uploaded_cover = $request->file('cover');

            // ambil extension file
            $extension = $uploaded_cover->getClientOriginalExtension();

            // membuat nama file random
            $filename = md5(time()) . '.' . $extension;

            // simpan file ke folder public/img

            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $uploaded_cover->move($destinationPath, $filename);

            //hapus cover lama jika ada

            if($book->cover) {
                $old_cover = $book->cover;
                $filepath = public_path() . DIRECTORY_SEPARATOR . 'img'
                . DIRECTORY_SEPARATOR . $book->cover;

                try {
                    File::delete($filepath);
                } catch (FileNotFoundException $e) {
                    // file sudah tidak ada
                }
            }

            // mengisi field cover di book dengan filename yg baru dibuat
            $book->cover = $filename;
            $book->save();
        }
            Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan $book->title"
        ]);

            return redirect()->route('book.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $book = Book::find($id);
        $cover = $book->cover;

        if(!$book->delete()) return redirect()->back();

        // handle hapus buku dari ajax
        if($request->ajax()) return response()->json(['id'=> $id]);

        //hapus cover lama jika ada

         if($cover) {
            $old_cover = $book->cover;
            $filepath = public_path() . DIRECTORY_SEPARATOR . 'img'
            . DIRECTORY_SEPARATOR . $book->cover;

            try {
                  File::delete($filepath);
                } catch (FileNotFoundException $e) {
                    // file sudah tidak ada
                }
        }

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "The books <b> $book->title </b> has been deleted"
            ]);
        return redirect()->route('book.index');
    }

    public function borrow($id) {
        try {
            $book = Book::findOrFail($id);
            Auth::user()->borrow($book);
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Borrow Book <b> $book->title </b> Success"
                ]);
        } catch (BookException $e) {
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => $e->getMessage()
                ]);
        } catch (ModelNotFoundException $e) {
            Session::flash("flash_notification", [
                "level" => "Danger",
                "message" => "Book <b> $book->title </b> Not Found"
                ]);
        }

        return redirect('/');
    }

    public function returnBack($book_id) {
        $borrowLog = BorrowLog::where('user_id', Auth::user()->id)
        ->where('book_id', $book_id)
        ->where('is_returned', 0)
        ->first();

        if ($borrowLog) {
            $borrowLog->is_returned = true;
            $borrowLog->save();

            Session::flash('flash_notification', [
                "level" => "success",
                "message" => " You have return books " . $borrowLog->book->title
            ]);
        }
        return redirect('/home');
    }

    public function export() {
        return view('book.export');
    }

    public function exportPost(Request $request) {
        // validasi
        $this->validate($request, [
            'author_id' => 'required',
            'type'=>'required|in:pdf,xls'
            ], [
                'author_id.required' => 'Please Select The Authors at least 1'
            ]);
        $books = Book::whereIn('id', $request->get('author_id'))->get();

        $handler = 'export' . ucfirst($request->get('type'));
        return $this->$handler($books);
    }

    public function exportXls($books) {
        Excel::create('Library Online Books Data', function($excel) use ($books) {
            // set property
            $excel->setTitle('Books Data of Library Online')
            ->setCreator(Auth::user()->name);

            $excel->sheet('Books Data', function ($sheet) use ($books) {
                $row = 1;
                $sheet->row($row, [
                    'Title',
                    'Amount',
                    'Stock',
                    'Authors'
                    ]);

                foreach ($books as $book) {
                    $sheet->row(++$row, [
                        $book->title,
                        $book->amount,
                        $book->stock,
                        $book->author->name
                        ]);
                }
            });
        })->export('xls');
    }

    public function exportPdf($books) {
        $pdf = PDF::loadview('pdf.book', compact('books'));
        return $pdf->download('book.pdf');
    }    
    public function generateExcelTemplate() { 
        Excel::create('Template Import Books', function($excel) {
            // set properties
            $excel->setTitle('Template Import Books')
            ->setCreator('Aladroo')
            ->setCompany('Aladroo')
            ->setDescription('Books Import Template Library Aladroo');

            $excel->sheet('Books Data', function($sheet){
                $row = 1;
                $sheet->row($row, [
                    'title',
                    'authors',
                    'amount'
                    ]);
            });
        })->export('xlsx');
    }

    public function importExcel(Request $request) {
        // validasi file yg diapload adalah excel
        $this->validate($request, ['excel' => 'required|mimes:xls,xlsx' ]);

        // ambil file yang baru di upload

        $excel = $request->file('excel');

        // baca sheet pertama

        $excels = Excel::selectSheetsByIndex(0)->load($excel, function($reader){
            // option jika ada
        })->get();

        // rule untuk validasi setiap row pada file excel

        $rowRules = [
        'title' => 'required',
        'amount' => 'required',
        'authors' => 'required'
        ];

        // catat semua id buku baru
        // ID ini kita butuhkan untuk menghitung total buku yang berhasil diimport

        $books_id =[];

        // looping setiap baris dari baris ke 2. karena baris ke 1 adalah header

        foreach ($excels as $row) {
            // membuat validasi untuk row di excel
            // kita buah baris yang sedang diproses menjadi array

            $validator =  Validator::make($row->toArray(), $rowRules);

            // skip baris ini jika tidak valid, langsung ke baris selanjutnya

            if($validator->fails()) continue;

            // syntax dibawah di eksekusi ketika baris valid
            // cek apakah penulis sudah terdaftar
            $author = Author::where('name', $row['authors'])->first();

            // buat penulis jika belum ada
            if(!$author) {
                $author = Author::create(['name' => $row['authors']]);
            }

            // buat buku baru
            $book = Book::create([
                'title' => $row['title'],
                'author_id' => $author->id,
                'amount' => $row['amount'],
                ]);
            // catat id buku yang baru dibuat
            array_push($books_id, $book->id);
        }
        // ambil semua buku yang baru dibuat
        $books = Book::whereIn('id', $books_id)->get();

        // redirect ke form jika tidak ada buku yang berhasil diimport
        if($books->count() == 0) {
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => "No one book imported!"
                ]);
            return redirect()->back();
        }
        // set feedback
        Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Success books imported is " . $books->count()
                ]);
        // tampilkan index buku
        return view('book.import-review')->with(compact('books'));
     }

}
