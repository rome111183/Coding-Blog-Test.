<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 
     *
     * 
     */
    public static function getUsers($pagination = 5){
        
        return User::orderBy('created_at', 'desc')->paginate($pagination);
    
    }

    /**
     * 
     *
     * 
     */
    public static function getUserById($id){
        
        return User::findOrFail($id);
    
    }

    /**
     * 
     *
     * 
     */
    public static function storeUser($request){
        
        $user = User::create([
            
            'first_name' => \Input::get('first_name'),
            
            'last_name' => \Input::get('last_name'),
            
            'username' => \Input::get('username'),
            
            'password' => bcrypt(\Input::get('password')),
            
            'role' => \Input::get('role'),
        
        ]);

        return $user->id;

    }

    /**
     * 
     *
     * 
     */
    public static function updateUser($user){
        
        $user->first_name = \Input::get('first_name');
        
        $user->last_name = \Input::get('last_name');
        
        $password = \Input::get('password');
        
        if(!empty($password))
        
            $user->password = bcrypt($password);
        
        $user->role = \Input::get('role');

        return $user->save();

    }

    /**
     * 
     *
     * 
     */
    public static function destroy($id){
        
        $user = User::withTrashed()->findOrFail($id);

        return $user->delete();

    }
}
