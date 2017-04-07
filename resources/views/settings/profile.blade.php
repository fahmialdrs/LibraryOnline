@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li><a href="{{ url('/home') }}"> Dashboard</a></li>
					<li class='active'>Profile</li>
				</ul>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Profile</h2>
					</div>
					<div class="panel-body">
						<table class="table">
							<tr>
								<td class="text-muted">Name</td>
								<td>{{ auth()->user()->name }}</td>
							</tr>
							<tr>
								<td class="text-muted">Email</td>
								<td>{{ auth()->user()->email }}</td>
							</tr>
							<tr>
								<td class="text-muted">Last Login</td>
								<td>{{ auth()->user()->last_login }}</td>
							</tr>
						</table>
						<a href="{{ url('/settings/profile/edit')}}" class="btn btn-primary">Edit</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection