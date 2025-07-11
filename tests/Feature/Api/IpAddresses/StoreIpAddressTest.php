<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddresses;

use Generator;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\Api\BaseTestCase;

class StoreIpAddressTest extends BaseTestCase
{
    use WithoutMiddleware;

    public static function invalidFieldsDataProvider(): Generator
    {
        yield 'Missing All fields' => [
            [],
        ];

        yield 'Missing IP Address' => [
            [
                'label' => fake()->word(),
                'comment' => fake()->sentence(),
            ],
        ];

        yield 'Invalid IP Address' => [
            [
                'ip_address' => '123.456.789',
                'label' => fake()->word(),
                'comment' => fake()->sentence(),
            ],
        ];

        yield 'Missing Label' => [
            [
                'ip_address' => fake()->ipv4(),
                'comment' => fake()->sentence(),
            ],
        ];

        yield 'Label too long' => [
            [
                'ip_address' => fake()->ipv4(),
                'label' => str_repeat('a', 256),
                'comment' => fake()->sentence(),
            ],
        ];
    }

    public static function validFieldsDataProvider(): Generator
    {
        yield 'IP v4' => [
            [
                'ip_address' => fake()->ipv4(),
                'label' => fake()->word(),
                'comment' => fake()->sentence(),
            ],
        ];

        yield 'IP v6' => [
            [
                'ip_address' => fake()->ipv6(),
                'label' => fake()->word(),
                'comment' => fake()->sentence(),
            ],
        ];
    }
    #[DataProvider('invalidFieldsDataProvider')]
    public function test_it_should_return_invalid_fields($data): void
    {
        $token = $this->generateToken();

        $response = $this->json(
            method: 'post',
            uri: route('api.ip-addresses.store'),
            data: $data,
            headers: [
                ...$this->headers,
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertExactJsonStructure([
            'message',
            'error_code',
            'errors',
        ]);
    }

    #[DataProvider('validFieldsDataProvider')]
    public function test_it_should_store_ip_address($data): void
    {
        $token = $this->generateToken();

        $response = $this->json(
            method: 'post',
            uri: route('api.ip-addresses.store'),
            data: $data,
            headers: [
                ...$this->headers,
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertExactJsonStructure([
            'message',
            'data' => [
                'id',
                'ip_address',
                'label',
                'comment',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
