<?php

namespace Tests\Feature\Api\IpAddresses;

use App\Models\IpAddress;
use Illuminate\Http\Response;
use Override;
use Tests\Feature\Api\BaseTestCase;

class GetIpAddressTest extends BaseTestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        IpAddress::factory(10)->create();
    }

    public function test_it_should_return_not_found(): void
    {
        $response = $this->json(
            method: 'get',
            uri: route('api.ip-addresses.show', ['ip_address_id' => 11]),
            headers: $this->headers
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

        $response = $this->json(
            method: 'get',
            uri: route('api.ip-addresses.show', ['ip_address_id' => $ipAddress->id]),
            headers: $this->headers
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
