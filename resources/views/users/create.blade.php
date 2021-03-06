@extends('layouts.app')


@section('content')
	<div class="container-lg">
		<div class="card">
			<div class="card-header">New User</div>
			<div class="card-body">
				<form method="POST" action="/users" enctype="multipart/form-data">
					@csrf
				  <div class="mb-3">
					    <label for="prefixname" class="form-label">Prefix Name</label>
					    <select class="form-control" name="prefixname" id="prefixname" required>
					    	<option value="">Select</option>
					    	@foreach($prefixnames as $prefixname)
					  			<option value="{{$prefixname}}">{{$prefixname}}</option>
					    	@endforeach
					    </select>
				  </div>
				  <div class="mb-3">
					    <label for="firstname" class="form-label">First Name</label>
					    <input type="text" class="form-control" name="firstname" id="firstname" required>
				  </div>

				  <div class="mb-3">
					    <label for="middlename" class="form-label">Middle Name</label>
					    <input type="text" class="form-control" name="middlename" id="middlename">
				  </div>

				  <div class="mb-3">
					    <label for="lastname" class="form-label">Last Name</label>
					    <input type="text" class="form-control" name="lastname" id="lastname" required>
				  </div>

				  <div class="mb-3">
					    <label for="suffixname" class="form-label">Suffix Name</label>
					    <input type="text" class="form-control" name="suffixname" id="suffixname" required>
				  </div>

				  <div class="mb-3">
					    <label for="username" class="form-label">Username</label>
					    <input type="text" class="form-control" name="username" id="username" required>
				  </div>

				  <div class="mb-3">
				  		<label for="email" class="form-label">Email address</label>
   						<input type="email" class="form-control" name="email" id="email" required>
				  </div>

				  <div class="mb-3">
				  		<label for="type" class="form-label">Type</label>
   						<input type="text" class="form-control" name="type" id="type" required>
				  </div>

				  <div class="mb-3">
				  		<label class="form-label" for="photo">Photo</label>
					    <input type="file" class="form-control" name="photo" id="photo">
				  </div>

				  <div class="mb-3">
				  		<label class="form-label" for="password">Password</label>
					    <input type="password" id="password" name="password"  class="form-control">
				  </div>

				  <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
@stop