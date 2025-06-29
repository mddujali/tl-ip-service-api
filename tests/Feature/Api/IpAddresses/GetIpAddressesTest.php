<?php

namespace Tests\Feature\Api\IpAddresses;

use App\Models\IpAddress;
use Illuminate\Http\Response;
use Override;
use Tests\Feature\Api\BaseTestCase;

class GetIpAddressesTest extends BaseTestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        IpAddress::factory(100)->create();
    }

    public function test_it_should_get_a_list_of_ip_addresses(): void
    {
        $response = $this->json(
            method: 'get',
            uri: route('api.ip-addresses.index'),
            headers: $this->headers
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
