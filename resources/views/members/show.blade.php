@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li><a href="{{ url('/home') }}"> Dashboard</a></li>
					<li><a href="{{ url('/admin/member') }}"> Member</a></li>
					<li class="active">Detail {{ $member->name }} </li>
				</ul>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Detail {{ $member->name }}</h2>
					</div>
					<div class="panel-body">
						<p>Borrowed books:</p>
						<table class="table table-condensed table-triped">
							<thead>
								<tr>
									<td>Title</td>
									<td>Borrowed Date</td>
								</tr>
							</thead>
							<tbody>
								@forelse ($member->borrowLogs()->borrowed()->get() as $log)
									<tr>
										<td>{{ $log->book->title }}</td>
										<td>{{ $log->created_at }}</td>
									</tr>
								@empty
								<tr>
									<td colspan="2">No Borrowed Data</td>
								</tr>
								@endforelse
							</tbody>
						</table>
						<p>Books already returned:</p>
						<table class="table table-condensed table-triped">
							<thead>
								<tr>
									<td>Title</td>
									<td>Returned Date</td>
								</tr>
							</thead>
							<tbody>
								@forelse ($member->borrowLogs()->returned()->get() as $log)
									<tr>
										<td>{{ $log->book->title }}</td>
										<td>{{ $log->updated_at }}</td>
									</tr>
								@empty
								<tr>
									<td colspan="2">No Borrowed Data</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection