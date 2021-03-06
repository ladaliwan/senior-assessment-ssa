<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserDetail;


class UserService implements UserServiceInterface
{
	/**
     * The model instance.
     *
     * @var App\User
     */
    protected $model;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Constructor to bind model to a repository.
     *
     * @param \App\User                $model
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Define the validation rules for the model.
     *
     * @param  int $id
     * @return array
     */
    public function rules($id = null)
    {
        return [    
            'prefixname' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'suffixname' => 'required',
            'username' => "required|max:255|unique:users,username," . $id .",id",
            'type' => 'required',
            'photo' => 'mimes:jpg,bmp,png',
            'email' => "required|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email," . $id  .",id",
            'password' => "required",
        ];
    }

    /**
     * 
     *
     * Retrieve all resources and paginate.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list()
    {
        $users = $this->model->get();

        $lists = $this->paginate($users);
        
        return $lists;
    }

    /**
     * Create model resource.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $attributes)
    {
        return  $this->model->firstOrCreate([
             'prefixname' => $attributes['prefixname'],
             'firstname' => $attributes['firstname'],
             'middlename' => $attributes['middlename'],
             'lastname' => $attributes['lastname'],
             'suffixname' => $attributes['suffixname'],
             'username' => $attributes['username'],
             'photo' => isset($attributes['photo']) ? $this->upload($attributes['photo']) : 'images/default-image.png',
             'type' => $attributes['type'],
             'email' => $attributes['email'],
             'password' => $this->hash($attributes['password']),
        ]);
    }

    /**
     * Retrieve model resource details.
     * Abort to 404 if not found.
     *
     * @param  integer $id
     * @return \Illuminate\Database\Eloquent\Model|is_null(var)
     */
    public function find(int $id):? Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update model resource.
     *
     * @param  integer $id
     * @param  array   $attributes
     * @return boolean
     */
    public function update(int $id, array $attributes): bool
    {
        $user = $this->find($id);   

        $photo = is_null($user->photo)  ? 'images/default-image.png' : $user->photo;

        $user->prefixname = $attributes['prefixname'];
        $user->firstname = $attributes['firstname'];
        $user->middlename = $attributes['middlename'];
        $user->lastname = $attributes['lastname'];
        $user->suffixname = $attributes['suffixname'];
        $user->username = $attributes['username'];
        $user->photo =  isset($attributes['photo']) ? $this->upload($attributes['photo']) : $photo;
        $user->type = $attributes['type'];
        $user->email = $attributes['email'];
        $user->password = $this->hash($attributes['password']);
        
        return $user->save();
    }

    /**
     * Soft delete model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function destroy($id)
    {
        $user = $this->find($id);;  

        $user->delete();
    }

    /**
     * Include only soft deleted records in the results.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listTrashed()
    {
        $users = $this->model->onlyTrashed()->get();

        $lists = $this->paginate($users);

        return $lists;
    }

    /**
     * Restore model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function restore($id)
    {
        $user = $this->model->withTrashed()->find($id)->restore();

        return $user;
    }

    /**
     * Permanently delete model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function delete($id)
    {
        $this->model->withTrashed()->find($id)->forceDelete();

        return;
    }

    /**
     * Generate random hash key.
     *
     * @param  string $key
     * @return string
     */
    public function hash(string $key): string
    {
        return Hash::make($key);
    }

    /**
     * Upload the given file.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file)
    {
       return $file->store('images', 'public');
    }

    protected function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,  ['path' => Paginator::resolveCurrentPath()]);
    }

    public function updateDetails(array $attributes, $user)
    {
        foreach($attributes as $attr){
            if($user->details->isEmpty()){
                $user->details()->firstOrCreate([
                    'key' => $attr['key'],
                    'value' => $attr['value'],
                    'type' => $attr['type'],
                    'status' => $attr['status']
                ]);    
            } else {

                UserDetail::where('key', $attr['key'])
                ->where('user_id', $user->id)
                ->update([
                    'key' => $attr['key'],
                    'value' => $attr['value'],
                    'type' => $attr['type'],
                    'status' => $attr['status']
                ]);
            }    
        }
             
    }
}
