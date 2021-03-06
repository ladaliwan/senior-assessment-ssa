@extends('layouts.app')	


@section('content')
	<div class="container-lg">
		<form method="POST" action="/users/{{$user->id}}" enctype="multipart/form-data">
			<div class="card">
				<div class="card-header">Edit User ID: {{$user->id}}</div>
				<div class="card-body">
					@csrf
					{{ method_field('PUT') }}
				  <div class="mb-3">
					    <label for="prefixname" class="form-label">Prefix Name</label>
					    <select class="form-control" value="{{$user->prefixname}}" name="prefixname" id="perfixname" required>
					    	<option value="">Select</option>
					    	@foreach($prefixnames as $prefixname)
					    		@if($user->prefixname == $prefixname)
					    			<option value="{{$prefixname}}" selected>{{$prefixname}}</option>
					    		@else
					    			<option value="{{$prefixname}}">{{$prefixname}}</option>
					    		@endif
					    	@endforeach
					    </select>
				  </div>
				  <div class="mb-3">
					    <label for="firstname" class="form-label">First Name</label>
					    <input type="text" class="form-control" value="{{$user->firstname}}" name="firstname" id="firstname" required>
				  </div>

				  <div class="mb-3">
					    <label for="middlename" class="form-label">Middle Name</label>
					    <input type="text" class="form-control" value="{{$user->middlename}}" name="middlename" id="middlename">
				  </div>

				  <div class="mb-3">
					    <label for="lastname" class="form-label">Last Name</label>
					    <input type="text" class="form-control" value="{{$user->lastname}}" name="lastname" id="lastname" required>
				  </div>

				  <div class="mb-3">
					    <label for="suffixname" class="form-label">Suffix Name</label>
					    <input type="text" class="form-control" value="{{$user->suffixname}}" name="suffixname" id="suffixname" required>
				  </div>

				  <div class="mb-3">
					    <label for="username" class="form-label">Username</label>
					    <input type="text" class="form-control" value="{{$user->username}}" name="username" id="username" required>
				  </div>

				  <div class="mb-3">
				  		<label for="email" class="form-label">Email address</label>
   						<input type="email" class="form-control" value="{{$user->email}}" name="email" id="email" required>
				  </div>

				  <div class="mb-3">
				  		<label for="type" class="form-label">Type</label>
   						<input type="text" class="form-control" value="{{$user->type}}" name="type" id="type" required>
				  </div>

				  <div class="mb-3">
				  		<label class="form-label" for="photo">Photo</label>

				  		<div class="card-header">Show User ID: {{$user->id}} Details
							<img width="100" height="100" src="{{ $user->avatar ?   asset('storage/'. $user->avatar) : asset('images/default-image.png' )}}">
						</div>


					    <input type="file" class="form-control" name="photo" id="photo">
				  </div>

				  <div class="mb-3">
				  		<label class="form-label" for="password">Password</label>
					    <input type="password" id="password" value="{{$user->password}}" name="password"  class="form-control">
				  </div>


				  <button type="submit" class="btn btn-primary">Update</button>
				
				</div>
			</div>
		</form>
	</div>
@stop