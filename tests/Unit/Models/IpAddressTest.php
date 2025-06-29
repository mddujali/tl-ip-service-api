<?php

namespace Tests\Unit\Models;

use App\Models\IpAddress;
use Override;

class IpAddressTest extends BaseModelTestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = app(IpAddress::class);

        $this->table = 'ip_addresses';

        $this->columns = [
            'id',
            'ip_address',
            'label',
            'comment',
            'created_at',
            'updated_at',
        ];

        $this->fillable = [
            'ip_address',
            'label',
            'comment',
        ];
    }
}
