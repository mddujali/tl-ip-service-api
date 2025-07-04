<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\IpAddress;

use App\Exceptions\Json\IpAddressForbiddenJsonException;
use App\Http\Requests\Api\BaseRequest;

class DeleteIpAddressRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->route('ip_address_id')
            && ( ! $this->has('user_id') || ! $this->has('user_role'))) {
            throw new IpAddressForbiddenJsonException(message: __('Deleting IP Address is not allowed.'));
        }
    }
}
