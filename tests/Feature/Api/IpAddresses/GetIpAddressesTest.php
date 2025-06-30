<?php

namespace Tests\Feature\Api\IpAddresses;

use App\Models\IpAddress;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Override;
use Tests\Feature\Api\BaseTestCase;

class GetIpAddressesTest extends BaseTestCase
{
    use WithoutMiddleware;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        IpAddress::factory(100)->create();
    }

    public function test_it_should_return_list_of_ip_addresses(): void
    {
        $token = $this->generateToken();

        $response = $this->json(
            method: 'get',
            uri: route('api.ip-addresses.index'),
            headers: [
                ...$this->headers,
                'Authorization' => 'Bearer ' . $token['data']['access_token'],
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJsonStructure([
            'message',
            'data' => [
                '*' => [
                        'id',
                        'ip_address',
                        'label',
                        'comment',
                        'created_at',
                        'updated_at',
                    ],
            ],
        ]);
    }
}
