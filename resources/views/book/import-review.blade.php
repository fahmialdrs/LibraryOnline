@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ul class="breadcrumb">
        <li><a href="{{ url('/home') }}">Dashboard</a></li>
        <li><a href="{{ url('/admin/books') }}">Books</a></li>
        <li><a href="{{ url('/admin/book/create') }}">Input Books</a></li>
        <li class="active">Books Review</li>
      </ul>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title">Book Review</h2>
        </div>

        <div class="panel-body">
          <p> <a class="btn btn-success" href="{{ url('/admin/book')}}">Done</a> </p>
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th>Title</th>
                <th>Authors</th>
                <th>Amount</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($books as $book)
                <tr>
                  <td>{{ $book->title }}</td>
                  <td>{{ $book->author->name }}</td>
                  <td>{{ $book->amount }}</td>
                  <td>
                    {!! Form::open(['url' => route('book.destroy', $book->id),
                    'id'           => 'form-'.$book->id, 'method'=>'delete',
                    'data-confirm' => 'Are you sure want to delete ' . $book->title . '?',
                    'class'        => 'form-inline js-review-delete']) !!}
                    {!! Form::submit('Delete', ['class'=>'btn btn-xs btn-danger']) !!}
                    {!! Form::close() !!}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <p> <a class="btn btn-success" href="{{ url('/admin/book')}}">Done</a> </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection