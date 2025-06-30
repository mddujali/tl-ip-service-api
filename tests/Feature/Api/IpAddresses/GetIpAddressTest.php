<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddresses;

use App\Models\IpAddress;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Override;
use Tests\Feature\Api\BaseTestCase;

class GetIpAddressTest extends BaseTestCase
{
    use WithoutMiddleware;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        IpAddress::factory(10)->create();
    }

    public function test_it_should_return_not_found(): void
    {
        $token = $this->generateToken();

        $response = $this->json(
            method: 'get',
            uri: route('api.ip-addresses.show', ['ip_address_id' => 11]),
            headers: [
                ...$this->headers,
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ]
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertExactJsonStructure([
            'message',
            'error_code',
            'errors',
        ]);
    }

    public function test_it_should_return_ip_address(): void
    {
        $ipAddress = IpAddress::query()->first();
        $token = $this->generateToken();

        $response = $this->json(
            method: 'get',
            uri: route('api.ip-addresses.show', ['ip_address_id' => $ipAddress->id]),
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
