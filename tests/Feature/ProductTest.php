<?php

namespace Tests\Feature;

use App\Models\ProductModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testListProduct()
    {
        $this->get('/api/product',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Success',
                'data' => [
                    [
                        'id' => 1,
                        'sku' => 'Test',
                        'name' => 'Test',
                        'stock' => 1,
                        'price' => 10000,
                        'image' => 'Test',
                        'category' => [
                            'id' => 1,
                            'name' => 'Category 1'
                        ]
                    ]
                ]
            ]);
    }

    public function testListProductCategory1()
    {
        $this->get('/api/product?category=1',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Success',
            'data' => [
                [
                    'category' => ['id' => 1, 'name' => 'Category 1']
                ]
            ]
        ]);
    }


    public function testCreateProductSuccess()
    {
        $this->post('/api/product', [
            'sku' => 'Test2',
            'name' => 'Test 2',
            'stock' => 2,
            'price' => 20000,
            'image' => 'image 2',
            'category_id' => '2',
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Created Success',
            'data' => [
                'sku' => 'Test2',
                'name' => 'Test 2',
                'stock' => 2,
                'price' => 20000,
                'image' => 'image 2'
            ]
        ]);
    }

    public function testCreateProductFail()
    {
        $this->post('/api/product', [
            'sku' => '',
            'name' => '',
            'stock' => '',
            'price' => '',
            'image' => '',
            'category_id' => '',
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => [
                    'sku' => ['The sku field is required.'],
                    'name' => ['The name field is required.'],
                    'stock' => ['The stock field is required.'],
                    'price' => ['The price field is required.'],
                    'image' => ['The image field is required.'],
                    'category_id' => ['The category id field is required.'],
                ],
            ]);
    }

    public function testCreateProductInvalidCategory()
    {
        $this->post('/api/product', [
            'sku' => 'Test2',
            'name' => 'Test 2',
            'stock' => 2,
            'price' => 20000,
            'image' => 'image 2',
            'category_id' => 100,
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => ['category_id' => ['The selected category id is invalid.']]
            ]);
    }

    public function testShowProductByIdSuccess()
    {
        $this->get('/api/product/1',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Success',
            'data' => [
                'id' => 1,
                'sku' => 'Test',
                'name' => 'Test',
                'stock' => 1,
                'price' => 10000,
                'image' => 'Test',
                'category' => [
                    'id' => 1,
                    'name' => 'Category 1'
                ]
            ]
        ]);
    }

    public function testShowProductByIdNotFound()
    {
        $this->get('/api/product/100',
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
    }

    public function testUpdateProductSuccess()
    {
        $this->put('/api/product/2', [
            'sku' => 'Test3',
            'name' => 'Test 3',
            'stock' => 3,
            'price' => 30000,
            'image' => 'image 3',
            'category_id' => 1,
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Update Success',
                'data' => [
                    'sku' => 'Test3',
                    'name' => 'Test 3',
                    'stock' => 3,
                    'price' => 30000,
                    'image' => 'image 3',
                    'category' => [
                        'id' => 1,
                        'name' => 'Category 1'
                    ]
                ]
            ]);
    }

    public function testUpdateProductFail()
    {
        $this->put('/api/product/100', [
            'sku' => 'Test3',
            'name' => 'Test 3',
            'stock' => 3,
            'price' => 30000,
            'image' => 'image 3',
            'category_id' => 1,
        ],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
    }

    public function testDeleteProductSuccess()
    {
        $this->delete('/api/product/2', [],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Deleted Success'
            ]);

        self::assertNull(ProductModel::find(2));
    }

    public function testDeleteProductFail()
    {
        $this->delete('/api/product/100', [],
            ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf']
        )->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data not found!',
                'data' => null
            ]);
    }


}
