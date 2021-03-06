@extends('layouts.app')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li><a href="{{ url('/home') }}">Dashboard</a></li>
					<li class="active">Books</li>
				</ul>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Books</h2>
					</div>

					<div class="panel-body">
						<p>
							<a href="{{ url('/admin/book/create') }}" class="btn btn-primary"> Create</a>
							<a class="btn btn-primary" href="{{ url('/admin/export/book') }}">Export</a>
						</p>
						{!! $html->table(['class'=> 'table-striped']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	{!! $html->scripts() !!}
@endsection