<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddresses;

use App\Models\IpAddress;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Override;
use Tests\Feature\Api\BaseTestCase;

class DeleteIpAddressTest extends BaseTestCase
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
            method: 'delete',
            uri: route(
                'api.ip-addresses.destroy',
                [
                    'user_id' => 1,
                    'user_role' => 'super-admin',
                    'ip_address_id' => 11,
                ]
            ),
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

    public function test_it_should_remove_ip_address(): void
    {
        $ipAddress = IpAddress::query()->first();
        $token = $this->generateToken();

        $response = $this->json(
            method: 'delete',
            uri: route(
                'api.ip-addresses.destroy',
                [

                    'user_id' => 1,
                    'user_role' => 'super-admin',
                    'ip_address_id' => $ipAddress->id
                ]
            ),
            headers: [
                ...$this->headers,
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJsonStructure([
            'message',
            'data' => [],
        ]);
    }
}
