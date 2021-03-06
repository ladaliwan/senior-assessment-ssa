<form method="POST" action="/users/{{$user->id}}/restore">
		@csrf
		{{ method_field('PUT') }}
	  <button type="submit" class="btn btn-primary btn-sm">Restore</button>
</form>