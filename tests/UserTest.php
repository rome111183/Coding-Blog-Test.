<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;


class UserTest extends TestCase
{
    /**
     * Test Login & Logout Page.
     *
     * @return void
     */
    public function testLogin()
    {
		$this->visit('/')
			->click('Login')
			->type('administrator', 'username')
			->type('administrator', 'password')
			->press('Login')
			->see('Dashboard')
			->click('Logout')
			->seePageIs('/')
			->see('Welcome');
    }

	/**
     * Test Create New User Page.
     *
     * @return void
     */
    public function testUserCreate()
    {
		$username = 'unitestUser'.rand(1,100);
		while(\DB::table('users')->where('username', '=', $username)->count()>0) {
			$username = 'unitestUser'.rand(1,100);
		}
	    
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$this->visit('/user/create')
			->see('Register new User')
			->type($username, 'first_name')
			->type('unitestUser1', 'last_name')
			->type($username, 'username')
			->type('unitestUser1', 'password')
			->type('unitestUser1', 'password_confirmation')
			->type('0', 'role')
			->press('Create')
			->visit('/user/lists')
			->seePageIs('/user/lists')
			->see('User List');
	}

	/**
     * Test Edit User Page.
     *
     * @return void
     */
    public function testUserEdit()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$userobj = User::orderBy('created_at', 'desc')->first();

		$this->visit('/user/edit/'.$userobj->id)
			->see('Edit User')
			->type($userobj->first_name.='-'.rand(1,100), 'first_name')
			->type($userobj->last_name, 'last_name')
			->type($userobj->username, 'username')
			->type($userobj->username, 'password')
			->type($userobj->username, 'password_confirmation')
			->type('0', 'role')
			->press('Update')
			->visit('/user/lists')
			->seePageIs('/user/lists')
			->see('User List');
	}

	/**
     * Test Soft Delete a User.
     *
     * @return void
     */
    public function testUserDelete()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$userobj = User::orderBy('created_at', 'desc')->first();

		$response = $this->call('POST', '/user/delete', ['id' => $userobj->id]);
	}

	/**
     * Test Users Listings page.
     *
     * @return void
     */
    public function testUserAll()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$response = $this->call('GET', '/user/lists');

    	$this->assertEquals(200, $response->status());
	}
}
