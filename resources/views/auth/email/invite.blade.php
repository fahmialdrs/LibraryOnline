<p>
	Hello {{ $member->name }}
</p>

<p>
	Our Admin already registering you as member in Library Online. here's your data to reach Library Online
	<br>
	<table>
		<tr>
			<td>
				email : 
			</td>
			<td>
				{{ $member->email }}
			</td>
		</tr>
		<tr>
			<td>
				Password :
			</td>
			<td>
				<strong> {{ $password }}</strong>
			</td>
		</tr>
	</table>

	please kindly login at <a href="{{ $login = url('login') }} "> {{ $login }}</a> <br>
	if you want to reset your password, you can visit <a href="{{ $reset = url('password/reset') }}">{{ $reset }}</a>
</p>