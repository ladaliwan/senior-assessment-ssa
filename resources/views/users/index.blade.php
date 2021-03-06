@extends('layouts.app')


@section('content')
	<div class="container-lg">
		<div class="card">
			<div class="card-header">
				<h4>List of Users</h4>
				<a class="btn btn-primary btn-md float-right" href="/users/create"> New User </a>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">#ID</th>
							<th scope="col">Prefix Name</th>
							<th scope="col">Name</th>
							<th scope="col">Suffix Name</th>
							<th scope="col">Username</th>
							<th scope="col">Email</th>
							<th scope="col">Type</th>
							<th scope="col" colspan="3">Photo</th>
							<th scope="col"></th>	
						</tr>
					</thead>
					<tbody>
					@foreach($users as $user)
						<tr>
							<th scope="row"><a href="/users/{{$user->id}}">{{ $user->id }} </a></th>
							<td>{{ $user->prefixname }}</td>
							<td>{{ $user->fullname }}</td>
							<td>{{ $user->suffixname }}</td>
							<td>{{ $user->username }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->type }} </td>
							<td>
								<img width="300" height="500" src="{{ asset($user->avatar) }}">
							</td>
							@if($user->id != '1')
							<td>
									@include('users.partials.delete_form')
							</td>
							@endif
						</tr>	
					@endforeach	
					</tbody>
				</table>
			</div>
		{!! $users->links() !!}
		</div>
	</div>
@endsection