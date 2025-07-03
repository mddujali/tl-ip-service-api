<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddresses;

use App\Enums\Role;
use App\Models\IpAddress;
use Generator;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\Api\BaseTestCase;

class UpdateIpAddressTest extends BaseTestCase
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
                'user_id' => 1,
                'user_role' => Role::SUPER_ADMIN->value,
                'ip_address' => '123.456.789',
                'label' => fake()->word(),
                'comment' => fake()->sentence(),
            ],
        ];

        yield 'Missing Label' => [
            [
                'user_id' => 1,
                'user_role' => Role::SUPER_ADMIN->value,
                'ip_address' => fake()->ipv4(),
                'comment' => fake()->sentence(),
            ],
        ];

        yield 'Label too long' => [
            [
                'user_id' => 1,
                'user_role' => Role::SUPER_ADMIN->value,
                'ip_address' => fake()->ipv4(),
                'label' => str_repeat('a', 256),
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

    public function test_it_should_update_ip_address(): void
    {
        $token = $this->generateToken();
        $ipAddress = IpAddress::factory()->create();

        $data = [
            'user_id' => 1,
            'user_role' => Role::SUPER_ADMIN->value,
            'ip_address' => fake()->ipv4(),
            'label' => fake()->word(),
            'comment' => fake()->sentence(),
        ];

        $response = $this->json(
            method: 'put',
            uri: route('api.ip-addresses.update', ['ip_address_id' => $ipAddress->id]),
            data: $data,
            headers: [
                ...$this->headers,
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
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
