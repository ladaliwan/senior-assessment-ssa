<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\UserService;

class SaveUserBackgroundInformation
{
    public $userService;

    protected $lists_prefix = [
        'Male' => ['Mr'],
        'Female' => ['Mrs', 'Ms']
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        $user = $event->user->fresh();

        $arr_details = array_merge(
            $this->fullNameDetails($user->fullname), 
            $this->middleInitialDetails($user->middleinitial), 
            $this->avatarDetails($user->avatar), 
            $this->genderDetails($user->prefixname)
        );

        $details = $this->alignDetails($arr_details);
        
        $this->userService->updateDetails($details, $user);
    }

    public function fullNameDetails($fullname)
    {
        return [
            'full_name' => $fullname,
        ];
    }

    public function middleInitialDetails($middleinitial)
    {
        return [
            'middle_initial' =>  $middleinitial
        ];
    }

    public function avatarDetails($avatar)
    {
        return [
            'avatar' =>  $avatar
        ];
    }

    public function genderDetails($prefixname)
    {
        foreach($this->lists_prefix as $gender => $prefix){
            if(in_array($prefixname, $prefix)){
                 return ['gender' => $gender];
            }
        }

        return ['gender' => ''];
    }

    public function alignDetails($details)
    {
        $temp_arr = array();

        foreach($details as $key => $value){
            $temp_arr[] = [
                'key' => ucfirst(str_replace("_"," ",$key)),
                'value' => $value,
                'type' => 'bio',
                'status' => 'normal',
            ];
        }

        return $temp_arr;
    }
}
