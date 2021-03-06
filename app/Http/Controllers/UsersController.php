<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
	protected $userService;
	protected $prefixnames;

	public function __construct(UserService $userService)
	{
		$this->middleware('auth');
		$this->userService = $userService;
		$this->prefixnames = config('app.prefix_names');
	}

	public function index()
	{
		$users = $this->userService->list();

		return view('users.index', compact('users'));
	}

	public function create()
	{
		$prefixnames = $this->prefixnames;
		return view('users.create', compact('prefixnames'));
	}

	public function store(UserRequest $request)
	{
 		$this->userService->store($request->except('_token'));

		return redirect('/users');
	}

	public function show($user)
	{
		$user = $this->userService->find($user);

		return view('users.show', compact('user'));
	}

	public function edit($user)
	{
		$user = $this->userService->find($user);
		$prefixnames = $this->prefixnames;

		return view('users.edit', compact('user', 'prefixnames'));
	}

	public function update(UserRequest $request,  $user)
	{
		$this->userService->update($user, $request->except('_token'));

		return redirect("/users/{$user}");
	} 

	public function destroy(User $user)
	{
		$user->delete();

		return redirect("/users");
	}

	public function trashed()
	{
		$users = $this->userService->listTrashed();

		return view('users.trashed', compact('users'));	
	}

	public function restore($user)
	{
		$this->userService->restore($user);

		return redirect("/users/trashed");
	}


	public function forcedelete($user)
	{
		$this->userService->delete($user);

		return redirect("/users/trashed");
	}
}
