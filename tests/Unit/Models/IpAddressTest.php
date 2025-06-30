<?php

declare(strict_types=1);

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
            'user_id',
            'ip_address',
            'label',
            'comment',
            'created_at',
            'updated_at',
        ];

        $this->fillable = [
            'user_id',
            'ip_address',
            'label',
            'comment',
        ];
    }
}
