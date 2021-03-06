@extends('layouts.app')


@section('content')
	<div class="container-fluid">
		<div class="row">
					<div class="col-md-5">
						<div class="card">
							<div class="card-header">Show User ID: {{$user->id}} Details
								<img width="100" height="100" src="{{ $user->avatar ?  asset('storage/'. $user->avatar) : asset('images/default-image.png' )}}">
							</div>
							<div class="card-body">
								<form method="POST" action="/user" enctype="multipart/form-data">
								  <div class="mb-3">
									    <label for="prefixname" class="form-label">Prefix Name</label>
									     <input type="text" class="form-control" value="{{$user->prefixname}}" name="prefixname" id="prefixname" readonly>
								  </div>
								  <div class="mb-3">
									    <label for="firstname" class="form-label">First Name</label>
									    <input type="text" class="form-control" value="{{$user->firstname}}" name="firstname" id="firstname" readonly>
								  </div>

								  <div class="mb-3">
									    <label for="middlename" class="form-label">Middle Name</label>
									    <input type="text" class="form-control" value="{{$user->middlename}}" name="middlename" id="middlename" readonly>
								  </div>

								  <div class="mb-3">
									    <label for="lastname" class="form-label">Last Name</label>
									    <input type="text" class="form-control" value="{{$user->lastname}}" name="lastname" id="lastname" readonly>
								  </div>

								  <div class="mb-3">
									    <label for="suffixname" class="form-label">Suffix Name</label>
									    <input type="text" class="form-control" value="{{$user->suffixname}}" name="suffixname" id="suffixname" readonly>
								  </div>

								  <div class="mb-3">
									    <label for="username" class="form-label">Username</label>
									    <input type="text" class="form-control" value="{{$user->username}}" name="username" id="username" readonly>
								  </div>

								  <div class="mb-3">
								  		<label for="email" class="form-label">Email address</label>
				   						<input type="email" class="form-control" value="{{$user->email}}" name="email" id="email" readonly>
								  </div>

								  <div class="mb-3">
								  		<label for="type" class="form-label">Type</label>
				   						<input type="text" class="form-control" value="{{$user->type}}" name="type" id="type" readonly>
								  </div>

								  <a href="/users/{{$user->id}}/edit" class="btn btn-primary">Edit</a>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="card">
						<div class="card-header">Show User Background Details</div>
						<div class="card-body">
							<table class="table">
								<thead>
									<tr>
										<th>Title</th>
										<th>Value</th>
										<th>Type</th>
										<th>Key</th>
									</tr>
								</thead>
								<tbody>
									@foreach($user->details  as $detail)
									<tr>
										<td><b>{{$detail->key}}</b></td>
										<td><b>{{$detail->value}}</b></td>
										<td ><b>{{$detail->type}}</b></td>
										<td><b>{{$detail->status}}</b></td>
									<tr>
									@endforeach
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop