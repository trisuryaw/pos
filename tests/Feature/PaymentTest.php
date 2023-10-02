<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{

    protected function setUp():void
    {
        parent::setUp();
        $this->defaultHeaders = ['Authorization' => 'Bearer 16|7h39tkJgJSInAjPGW38TdWut6Wh5tBUldWLjx1Jkd5442abf'];
    }


    public function testListPayments()
    {

    }

    public function testCreatePaymentSuccess()
    {

    }

    public function testCreatePaymentFail()
    {
        $this->post('/api/payment', [
            'name' => '',
            'type' => ''
        ])->assertStatus(400)
        ->assertJson([
            'success' => false,
        ]);
    }


}
