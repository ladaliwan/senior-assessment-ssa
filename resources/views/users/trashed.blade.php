@extends('layouts.app')


@section('content')
	<div class="container-lg">
		<div class="card">
			<div class="card-header">
				<h4>List of Deleted Users</h4>
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
							<th scope="col" colspan="3"></th>	
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
							<td>{{ $user->photo }}</td>
							<td>
								@include('users.partials.delete_trashed_form')
								@include('users.partials.restore_form')
							</td>
						</tr>	
					@endforeach	
					</tbody>
				</table>
			</div>
		{!! $users->links() !!}
		</div>
	</div>
@endsection