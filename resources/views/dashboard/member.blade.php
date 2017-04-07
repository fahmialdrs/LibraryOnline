@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Dashboard</h2>
					</div>
					<div class="panel-body">
						Welcome to Library
						<table class="table">
							<tr>
								<td class="text-muted">
									Borrowed Books
								</td>
								<td>
									@if ($borrowLogs->count() == 0)
										there's no books borrowed by you
									@endif

									<ul>
										@foreach ($borrowLogs as $borrowLog)
											<li>
												{!! Form::open(['url' => route('member.book.return', $borrowLog->book_id),
												'method' => 'put',
												'class' => 'form-inline js-confirm',
												'data-confirm' => "Are you sure want to return " . $borrowLog->book->title . "?"]) !!}

												{{ $borrowLog->book->title }}
												{!! Form::submit('Return', ['class' => 'btn btn-xs btn-default']) !!}

												{!! Form::close() !!}

											</li>
										@endforeach
									</ul>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection