<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BalanceTest extends TestCase
{
    /**
     *
     */
    public function testBalance()
    {
        $response = $this->withHeaders([
            'token' => 'test',
        ])
            ->get('api/v1/balance/');

        $response->assertStatus(200);
        $response->assertExactJson([1234.56]);
    }

    /**
     *
     */
    public function testWrongTokenBalance()
    {
        $response = $this->withHeaders([
            'token' => 'wrongToken',
        ])
            ->get('api/v1/balance');

        $response->assertStatus(401);
    }

    public function testBalanceDetails()
    {
        $response = $this->withHeaders([
            'token' => 'test',
        ])
            ->get('api/v1/balance/details');

        $response->assertStatus(200);
        $response->assertExactJson([
            'balance' => 1234.56,
            'paid' => 4567.89,
        ]);
    }
    public function testReferral()
    {
        $response = $this->withHeaders([
            'token' => 'test',
        ])
            ->get('api/v1/balance/referral');

        $response->assertStatus(200);
        $response->assertExactJson([
            'referrals' => [
                'current' => 4,
                'max' => 25,
                'percent' => 16,
            ],
            'balance' => 2345.67,
            'award' => 25,
            'paid' => 5678.90,
        ]);
    }
}
