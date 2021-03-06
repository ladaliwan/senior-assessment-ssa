<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use App\Models\User;

class UsersControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;


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
            'password' => 'E.5h2stR[4B{n~LM'
        ];
    }

    protected function user($param = null)
    {
        return  User::factory()->create($param);
    }
    

    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_only_access_the_users_page()
    {
        $this->get('/users')
            ->assertRedirect('/login');


        $this->signIn();
        
        $this->get('/users')
            ->assertStatus(200)
            //to see if paginated
            ->assertSee('1')
            ->assertSee('2');    
    } 


    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_only_access_the_user_create_page()
    {
        $this->get('/users/create')
            ->assertRedirect('/login');


        $this->signIn();
        
        $this->get('/users/create')
            ->assertStatus(200);    
    } 

    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_only_access_the_user_show_page()
    {
        $user = $this->user();

        $this->get("/users/{$user->id}")
            ->assertRedirect('/login');


        $this->signIn();
        
        $this->get("/users/{$user->id}")
            ->assertStatus(200)
            ->assertSee($user->firstname);    
    } 


    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_only_access_the_user_trashed_page()
    {
        $user = $this->user();

        $this->get("/users/trashed")
            ->assertRedirect('/login');


        $this->signIn();
        
        $this->get("/users/trashed")
            ->assertStatus(200);    
    } 


    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_create_a_user()
    {
        $this->signIn();

        $this->post('/users', $this->arr());

        $user = User::skip(1)->first();

        $this->assertEquals($user->firstname, $this->arr()['firstname']);

        $this->assertCount(4, $user->details);  
    } 

    /**
     * @test
     * @return void
     */
    function a_requires_to_fill_the_field()
    {
        $this->signIn();

        $arr = [
            'middlename' => 'Q',
            'suffixname' => 'LA',
            'username' => 'louiedaliwan',
            'email' => 'test@gmail.com',
            'type' => 'O',
        ];


        $this->post('/users', $arr)
            ->assertSessionHasErrors(['prefixname', 'firstname', 'lastname','password']);
    } 


    /**
     * @test
     * @return void
     */
    function a_requires_unique_email()
    {
        $this->signIn();

        $this->user(['email' => 'test@gmail.com']);

        $arr = [
            'prefixname' => 'Mr',
            'firstname' => 'Louie',
            'middlename' => 'Q',
            'lastname' => 'Daliwan',
            'suffixname' => 'LA',
            'username' => 'louiedaliwan',
            'email' => 'test@gmail.com',
            'type' => 'O',
            'password' => 'E.5h2stR[4B{n~LM'
        ];


        $this->post('/users', $arr)
            ->assertSessionHasErrors(['email']);
    }


    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_update_existing_user()
    {
        $this->signIn();

        $this->post('/users', $this->arr());

        $user = User::skip(1)->first();

        $this->assertEquals($user->firstname, $this->arr()['firstname']);

        $this->assertEquals($user->details[3]->value, 'Male');

        $new_arr = [
            'prefixname' => 'Mrs',
            'firstname' => 'Test',
            'middlename' => 'Q',
            'lastname' => 'Daliwan',
            'suffixname' => 'LA',
            'username' => 'louiedaliwan',
            'email' => 'test@gmail.com',
            'type' => 'O',
            'password' => 'E.5h2stR[4B{n~LM'
        ];
    
        $this->put("/users/{$user->id}", $new_arr);

        $this->assertNotEquals($user->fresh()->firstname, $this->arr()['firstname']);

        $this->assertNotEquals($user->fresh()->details[3]->value, 'Male');

    } 

    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_archive_the_user()
    {
        $this->signIn();

        $user = $this->user();

        $this->delete("/users/{$user->id}");

        $this->assertNotNull($user->fresh()->deleted_at);
    }

    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_restored_the_user()
    {
        $this->signIn();

        $user = $this->user();

        $this->put("/users/{$user->id}");

        $this->assertNull($user->fresh()->deleted_at);
    }


    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_restore_the_user()
    {
        $this->signIn();

        $user = $this->user();

        $this->put("/users/{$user->id}/restore");

        $this->assertNull($user->fresh()->deleted_at);
    }


    /**
     * @test
     * @return void
     */
    function a_authenticated_user_can_forced_delete_the_user()
    {
        $this->signIn();

        $user = $this->user();

        $this->delete("/users/{$user->id}/force-delete");

        $this->assertDeleted($user);
    }

}
