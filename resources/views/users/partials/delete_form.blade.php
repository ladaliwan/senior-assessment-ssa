<form method="POST" action="/users/{{$user->id}}" enctype="multipart/form-data">
		@csrf
		{{ method_field('DELETE') }}
	  <button type="submit" class="btn btn-danger">Archive</button>
</form>