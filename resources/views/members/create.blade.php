@extends('layouts.app')
@section('title', 'Input Member')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="{{ url('/home') }}">Dashboard</a></li>
				<li><a href="{{ url('/admin/member') }}">Member</a></li>
				<li class="active">Input Member</li>
			</ul>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">Input Member</h2>
				</div>

				<div class="panel-body">
					{!! Form::open(['url'=> route('member.store'), 'method'=>'post', 'files' => 'true', 'class'=>'form-horizontal']) !!}
					@include('members._form')
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection