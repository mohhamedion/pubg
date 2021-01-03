<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testRegister()
    {
        $response = $this->json('POST','api/v1/user/login/',['email' => 'newtestuser@gmail.com']);

        $response->assertStatus(200);

        return ['response' => $response,'data' => ['email' => 'newtestuser@gmail.com']];
    }

    /**
     * @depends testRegister
     */

    public function testLogin($data)
    {
        $response = $this->json('POST','api/v1/user/login/', $data['data']);

        $response->assertStatus(200);

        $this->assertEquals($response->headers->get('token'),$data['response']->headers->get('token'));
    }
}
