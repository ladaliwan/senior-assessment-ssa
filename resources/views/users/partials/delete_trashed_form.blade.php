<form method="POST" action="/users/{{$user->id}}/force-delete">
		@csrf
	 	@method('DELETE')
	  <button type="submit" class="btn btn-danger btn-sm">Force Delete</button>
</form>