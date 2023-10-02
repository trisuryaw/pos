<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class CategoryTest extends TestCase
{
    public function testListCategory()
    {
        $request = $this->get('/api/category',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        );
        $request->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Success'
            ]);
        self::assertNotNull($request->decodeResponseJson()['data']);
    }

    public function testShowByIdCategorySuccess()
    {
        $request = $this->get('/api/category/1',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        );
        $request->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Success'
            ]);

        assertNotNull($request->decodeResponseJson()['data']);
    }

    public function testShowByIdCategoryNotFound()
    {
        $request = $this->get('/api/category/100',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        );

        $request->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Success'
            ]);

        self::assertNull($request->decodeResponseJson()['data']);
    }

    public function testCreateCategorySuccess()
    {
        $this->post('/api/category', [
            'name' => 'Category 3'
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Created Success',
                'data' => [
                    'name' => 'Category 3'
                ]
            ]);
    }

    public function testCreateCategoryFail()
    {
        $this->post('/api/category', [
            'name' => ''
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testUpdateCategorySuccess()
    {
        $this->put('/api/category/4', [
            'name' => 'Category 4'
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Updated Success',
                'data' => [
                    'id' => 4,
                    'name' => 'Category 4'
                ]
            ]);
    }

    public function testUpdateCategoryFail()
    {
        $this->put('/api/category/100', [
            'name' => ''
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => [
                    'name' => ['The name field is required.']
                ]
            ]);
    }

    public function testUpdateCategoryNotFound()
    {
        $this->put('/api/category/100', [
            'name' => 'Category 101'
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data not found!'
            ]);
    }

    public function testDeleteCategorySuccess()
    {
        $this->delete('/api/category/4', [],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Deleted Success'
            ]);

        $request = $this->get('/api/category/4',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->decodeResponseJson();

        self::assertNull($request['data']);
    }


    public function testDeleteCategoryNotFound()
    {
        $this->delete('/api/category/100', [],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
    }

}
