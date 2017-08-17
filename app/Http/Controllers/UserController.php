<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class UserController extends Controller
{
    protected $roles;

    public function __construct() {
        
        $this->roles = ['1' => 'admin', '0' => 'user'];

    }

    /**
	 * Display a listing of the Users
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function index(){ 
        
        $users = User::getUsers();

        return view('user.list', ['users' => $users, 'roles' => $this->roles]);
    
    }

    /**
	 * Show the form for creating a new User
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function create(){
        
        return view('auth.register');
    
    }
    
    /**
	 * Store a newly created user in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function store(Requests\UserCreateRequest $request){
        
        $user = User::storeUser($request);

        \Session::flash('flash_message','successfully saved.');

        return redirect()->route("user.lists");
    
    }
    
    /**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function read($id){
       
        return view('user.profile');
    
    }

    /**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function edit($id){
        
        $user = User::getUserById($id);

        return view('user.edit', ['user' => $user]);
    
    }

    /**
	 * Update the specified user in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function update(Requests\UserEditRequest $request, $id){
        
        $user = User::getUserById($id);

        $user = User::updateUser($user);

        \Session::flash('flash_message','successfully saved.');

        return redirect()->route("user.lists");
    }

    /**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function delete(Requests\UserDeleteRequest $request){
       
        $user = User::destroy($request['id']);

        \Session::flash('flash_message','successfully deleted.');
        
        return redirect()->route("user.lists");
    }
}
