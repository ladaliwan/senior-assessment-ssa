<?php

namespace Tests\Unit\Listeners;
use App\Listeners\SaveUserBackgroundInformation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\UserService;
use Illuminate\Http\Request;
// use PHPUnit\Framework\TestCase;

class SaveUserBackgroundInformationTest extends TestCase
{
	use RefreshDatabase, WithFaker;
 	
 	protected $userClass;
    protected $userService;
    protected $request;
    protected $saveUserBackgroundInformation;

    public function setUp(): void
    {
    	parent::setUp();

        $this->userClass = new User();
        $this->request = new Request();
        $this->userService = new UserService($this->userClass, $this->request);
        $this->saveUserBackgroundInformation = new SaveUserBackgroundInformation($this->userService);
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
    function it_returns_an_array_of_key_fullname_and_value()
    {
    	$user = $this->user();

		$result = $this->saveUserBackgroundInformation->fullNameDetails($user->fullname);

		$this->assertTrue(array_key_exists('full_name', $result));
		$this->assertEquals($user->fullname, $result['full_name']);

    }


    /**
     * @test
     * @return void
     */
    function it_returns_an_array_of_key_middle_initial_and_value()
    {
    	$user = $this->user();

		$result = $this->saveUserBackgroundInformation->middleInitialDetails($user->middleinitial);

		$this->assertTrue(array_key_exists('middle_initial', $result));
		$this->assertEquals($user->middleinitial, $result['middle_initial']);

    }


    /**
     * @test
     * @return void
     */
    function it_returns_an_array_of_key_avatar_and_value()
    {
    	$user = $this->user();

		$result = $this->saveUserBackgroundInformation->avatarDetails($user->avatar);

		$this->assertTrue(array_key_exists('avatar', $result));
		$this->assertEquals($user->avatar, $result['avatar']);

    }

    /**
     * @test
     * @return void
     */
    function it_returns_an_array_of_key_gender_and_value()
    {
    	$user = $this->user();

		$result = $this->saveUserBackgroundInformation->genderDetails($user->prefixname);

		$this->assertTrue(array_key_exists('gender', $result));
		$this->assertNotNull($result['gender']);

    }

    /**
     * @test
     * @return void
     */
    function it_returns_an_array_of_align_details()
    {
    	$arr_details = [
    		'full_name' => 'Test Admin',
    		'middle_initial' => 'Q',
    		'avatar' => 'photo1.jpg',
    		'gender' => 'Male',
    		
    	];

		$result = $this->saveUserBackgroundInformation->alignDetails($arr_details);

		$expected_result = [
			0 => [
				'key' => 'Full name',
				'value' => 'Test Admin',
				'type' => 'bio',
				'status' => 'normal'
			],
			1 => [
				'key' => 'Middle initial',
				'value' => 'Q',
				'type' => 'bio',
				'status' => 'normal'
			],
			2 => [
				'key' => 'Avatar',
				'value' => 'photo1.jpg',
				'type' => 'bio',
				'status' => 'normal'
			],
			3 => [
				'key' => 'Gender',
				'value' => 'Male',
				'type' => 'bio',
				'status' => 'normal'
			]
		];

		$this->assertEquals($expected_result, $result);
    }

}
