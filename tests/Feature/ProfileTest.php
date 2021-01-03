<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProfileTest extends TestCase
{
    /**
     *
     */
    public function testProfile()
    {
        $response = $this->withHeader('token', 'test')
            ->get('/api/v1/profile/');

        $response->assertOk()
            ->assertExactJson([
                'profile'  => [
                    'username' => 'test1',
                    'email'    => 'test@gmail.com',
                    'phone'    => '+3810664742281',
                    'gender'   => 'female',
                ],
                'progress' => [
                    'profile'   => [
                        'level'   => 1,
                        'current' => 1,
                        'max'     => 10,
                        'percent' => 10,
                    ],
                    'tasks'     => [
                        'level'   => 1,
                        'current' => 1,
                        'max'     => 50,
                        'percent' => 2,
                    ],
                    'videos'    => [
                        'level'   => 2,
                        'current' => 2,
                        'max'     => 600,
                        'percent' => 0,
                    ],
                    'partners'  => [
                        'level'   => 3,
                        'current' => 3,
                        'max'     => 15,
                        'percent' => 20,
                    ],
                    'referrals' => [
                        'level'   => 4,
                        'current' => 4,
                        'max'     => 25,
                        'percent' => 16,
                    ],
                ],
            ]);
    }

    /**
     *
     */
    public function testUpdateProfile()
    {
        $response = $this->withHeaders([
            'token' => 'test',
        ])
            ->json('POST', 'api/v1/profile', [
                'username' => 'test',
                'email'    => 'test1@gmail.com',
                'phone'    => '+380664742281',
                'gender'   => 'male',
            ]);

        $response->assertStatus(200);
    }

    /**
     *
     */
    public function testWrongTokenProfile()
    {
        $response = $this->withHeaders([
            'token' => 'wrongToken',
        ])
            ->get('api/v1/profile');

        $response->assertStatus(401);
    }

    /**
     *
     */
    public function testWrongTokenUpdateProfile()
    {
        $response = $this->withHeaders([
            'token' => 'wrongTest',
        ])
            ->json('POST', 'api/v1/profile', [
                'username' => 'test',
                'email'    => 'test@gmail.com',
                'phone'    => '+380664742281',
                'gender'   => 'male',
            ]);

        $response->assertStatus(401);
    }

    /**
     * @dataProvider wrongDataProvider
     */
    public function testWrongData($data)
    {
        $response = $this->withHeaders([
            'token' => 'test',
        ])
            ->json('POST', 'api/v1/profile', $data);

        $response->assertStatus(422);
    }

    public function wrongDataProvider()
    {
        return [
            [
                [
                    'username' => 1245,
                ],
            ],
            [
                [
                    'phone' => 'testte.com',
                ],
            ],
            [
                [
                    'phone' => 124541,
                ],
            ],
            [
                [
                    'gender' => 124541,
                ],
            ],
        ];
    }
}
