<?php

namespace Tests\Unit\Event;

// use PHPUnit\Framework\TestCase;
use App\Services\UserService;
// use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\UserSaved;

class UserSavedTest extends TestCase
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

    protected function user()
    {
        return  User::factory()->create();
    }
 	


 	/**
     * @test
     * @return void
     */
    function it_can_dispatch_the_event_when_created_a_user()
    {
        Event::fake();

        $this->userService->store($this->arr());

        $user = User::first();

        Event::assertDispatched(UserSaved::class, function($e) use ($user){
            return $e->user->id = $user->id;
        });

    } 

    /**
     * @test
     * @return void
     */
    function it_can_dispatch_the_event_when_updated_a_user()
    {
        Event::fake();

        $user = $this->user();
    
        $result_actions = $this->userService->update($user->id, $this->arr());

        Event::assertDispatched(UserSaved::class, function($e) use ($user){
            return $e->user->id = $user->id;
        });

    }    
}
