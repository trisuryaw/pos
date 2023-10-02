<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testLoginSuccess()
    {
        $this->post('/api/user/login', [
            'username' => 'test',
            'password' => 'password',
        ])->assertStatus(200)
            ->assertJson([
            'success' => true,
            'message' => 'Success'
        ]);

        $token = $this->post('/api/user/login', [
                    'username' => 'test',
                    'password' => 'password',
                ])->decodeResponseJson();
        dd($token);
    }

    public function testLoginFieldsRequired()
    {
        $this->post('/api/user/login', [
            'username' => '',
            'password' => '',
        ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => [
                    'username' => ['The username field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testUsernameOrPasswordIsWrong()
    {
        $this->post('/api/user/login', [
            'username' => 'salah',
            'password' => 'salah',
        ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Username or Password is wrong!'
            ]);
    }

    public function testFetchUsers()
    {
        $this->get('/api/users', [
            'Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf'
        ])->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Success'
        ]);
    }

    public function testCreateUserSuccess()
    {
        $this->post('/api/user', [
            'name' => 'Surya',
            'username' => 'surya',
            'email' => 'surya@gmail.com',
            'password' => '123'
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf'])
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Success',
                'data' => [
                        'name' => 'Surya',
                        'username' => 'surya',
                        'email' => 'surya@gmail.com',
                ]
            ]);
    }

    public function testCreateUserFail()
    {
        $this->post('/api/user', [
            'name' => '',
            'username' => '',
            'email' => '',
            'password' => ''
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'username' => ['The username field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testShowUserByIdSuccess()
    {
        $this->get('/api/user/1',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'name' => 'Test',
                'username' => 'test',
                'email' => 'test@gmail.com'
            ]
        ]);
    }

    public function testShowUserByIdNotFound()
    {
        $this->get('/api/user/100',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Data not found!',
            'data' => null
        ]);
    }


    public function testUpdateUserSuccess()
    {
        $this->put('/api/user/19', [
            'name' => 'Suryaa',
            'username' => 'suryaa',
            'email' => 'surya@gmail.com',
            'password' => '123'
        ], ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Update Success',
            'data' => [
                'id' => 19,
                'name' => 'Suryaa',
                'username' => 'suryaa',
                'email' => 'surya@gmail.com'
            ]
        ]);
    }

    public function testUpdateUserFail()
    {
        $this->put('/api/user/100', [
            'name' => 'Test 100',
            'username' => 'test100',
            'email' => 'test100@gmail.com',
            'password' => '123'
        ], ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Data not found!',
            'data' => null
        ]);
    }

    public function testDeleteUserSuccess()
    {
        $this->delete('/api/user/19',[],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Deleted Success'
            ]);
    }

    public function testDeleteUserFail()
    {
        $this->delete('/api/user/19',[],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
    }

}
