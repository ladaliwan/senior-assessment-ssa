<?php

namespace Tests\Unit;

use App\Services\UserService;
// use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\UserDetail;

class UserServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $userClass;
    protected $request;
    protected $userService;

    public function setUp(): void
    {
    	parent::setUp();

        $this->userClass = new User();
        $this->request = new Request();
        $this->userService = new UserService($this->userClass, $this->request);
    }


    protected function arr(): array
    {
    	return [
			'prefixname' => 'Mr',
			'firstname' => 'Louie',
			'middlename' => 'Q',
			'lastname' => 'Daliwan',
			'suffixname' => 'LA',
			'username' => 'louiedaliwan',
			'email' => 'test@gmail.com',
			'type' => 'O',
			'password' => 'testLouie'
		];
    }


    protected function users()
    {
    	return User::factory()->count(100)->create();
    }


    protected function user()
    {
    	return  User::factory()->create();
    }

    protected function usersTrashed()
    {
    	return  User::factory()->create([
    		'deleted_at' => Carbon::now(),
    	]);
    }

    protected function userTrashed()
    {
    	return  User::factory()->create([
    		'deleted_at' => Carbon::now()
    	]);
    }

    /**
     * @test
     * @return void
     */
    function it_can_return_a_paginated_list_of_users()
    {
    	$this->users();

		// Assertions
    	$this->assertInstanceOf(LengthAwarePaginator::class, $this->userService->list());
    	$this->assertTrue(array_key_exists('first_page_url', $this->userService->list()->toArray()));
    	$this->assertTrue(array_key_exists('last_page_url', $this->userService->list()->toArray()));

    }

    /**
     * @test
     * @return void
     */
    function it_can_store_a_user_to_database()
    {
		
		$this->userService->store($this->arr());


		// Assertions
		$this->assertDatabaseHas('users',[
			 "prefixname" => "Mr",
		     "firstname" => "Louie",
		     "middlename" => "Q",
		     "lastname" => "Daliwan",
		     "suffixname" => "LA",
		     "username" => "louiedaliwan",
		     "type" => "O",
		     "email" => "test@gmail.com",
		]);

        $this->assertDatabaseHas('user_details',[
             "value" => 'Male'
        ]);
    }

    /**
     * @test
     * @return void
     */
    function it_can_find_and_return_an_existing_user()
    {
    	$user = $this->user();
		
		$exists_user = $this->userClass->find($user->id);

		$this->assertEquals($exists_user->fullname, $user->fullname);
    }

    /**
     * @test
     * @return void
     */
    function it_can_update_an_existing_user()
    {
    	$user = $this->user();
	
    	$result_actions = $this->userService->update($user->id, $this->arr());

    	$this->assertEquals($user->fresh()->firstname, $this->arr()['firstname']);
    	$this->assertTrue($result_actions);
    }

    /**
     * @test
     * @return void
     */
    function it_can_soft_delete_an_existing_user()
    {
		$user = $this->user();

		$this->userService->destroy($user->id);

		$this->assertNotNull($user->fresh()->deleted_at);
    }

    /**
     * @test
     * @return void
     */
    function it_can_return_a_paginated_list_of_trashed_users()
    {
    	$this->usersTrashed();

		// Assertions
    	$this->assertInstanceOf(LengthAwarePaginator::class, $this->userService->listTrashed());
    	$this->assertTrue(array_key_exists('first_page_url', $this->userService->listTrashed()->toArray()));
    	$this->assertTrue(array_key_exists('last_page_url', $this->userService->listTrashed()->toArray()));
    }

    /**
     * @test
     * @return void
     */
   	function it_can_restore_a_soft_deleted_user()
    {
		$user = $this->userTrashed();

		$this->userService->restore($user->id);

		$this->assertNull($user->fresh()->deleted_at);
    }

    /**
     * @test
     * @return void
     */
    function it_can_permanently_delete_a_soft_deleted_user()
    {
    	$user = $this->userTrashed();

    	$this->userService->delete($user->id);

    	$this->assertEquals(0, $this->userClass->count());
    }

    /**
     * @test
     * @return void
     */
    function it_can_upload_photo()
    {
    	$arr = $this->arr();

    	$arr['photo'] = UploadedFile::fake()->image('photo1.jpg');

    	$this->userService->store($arr);

    	$user = $this->userClass->first();

    	Storage::disk('public')->assertExists("{$user->photo}");
    }

    /**
     * @test
     * @return void
     */
    function it_can_store_the_background_details_a_created_user()
    {
        $this->userService->store($this->arr());

        $user = User::first();

        $this->assertCount(4, $user->details);
    }


    /**
     * @test
     * @return void
     */
    function it_can_update_the_background_details_a_created_user()
    {
        $user = $this->user();

        $this->assertEquals('Male', $user->details[3]->value);

        $arr = [
            'prefixname' => 'Mrs',
            'firstname' => 'Jona',
            'middlename' => 'Q',
            'lastname' => 'Daliwan',
            'suffixname' => 'LA',
            'username' => 'louiedaliwan',
            'email' => 'test@gmail.com',
            'type' => 'O',
            'password' => 'testLouie'
        ];


        $result_actions = $this->userService->update($user->id, $arr);

        $this->assertEquals('Female', $user->fresh()->details[3]->value);
    }



}
