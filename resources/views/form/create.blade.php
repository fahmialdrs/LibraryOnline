@extends('layouts.app')

@section('title', 'Form Berita')
@section('content')
	<div class="">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-area">
                        {!! Form::open(['url' => 'post/save', 'files'=>true]) !!}
                            <div class="text-center">
                                <h3>Form Berita</h3>
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                {!! Form::label('tanggal', 'Tanggal', ['class' => 'awesome']) !!}
                                {!! Form::date('tanggal',\Carbon\Carbon::now()) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('judul', 'Judul', ['class' => 'awesome']) !!}
                                {!! Form::text('isi') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('isi', 'isi', ['class' => 'awesome']) !!}
                                {!! Form::textarea('isi') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('foto', 'foto', ['class' => 'awesome']) !!}
                                {!! Form::file('foto') !!}
                            </div>
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <a href="{{route('show')}}">BACK</a>        
        </div>
@endsection