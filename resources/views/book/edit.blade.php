@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="breadcrumb">
          <li><a href="{{ url('/home') }}">Dashboard</a></li>
          <li><a href="{{ url('/admin/book') }}">Books</a></li>
          <li class="active">Edit Books</li>
        </ul>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Edit Books</h2>
          </div>

          <div class="panel-body">
            {!! Form::model($book, ['url' => route('book.update', $book->id),
              'method' => 'put', 'files'=>'true', 'class'=>'form-horizontal']) !!}
            @include('book._form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection