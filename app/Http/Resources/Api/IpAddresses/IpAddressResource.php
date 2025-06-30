<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\IpAddresses;

use App\Http\Resources\Api\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property-read int $id
 * @property-read string $ip_address
 * @property-read string $label
 * @property-read string $comment
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class IpAddressResource extends BaseJsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ip_address,
            'label' => $this->label,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
