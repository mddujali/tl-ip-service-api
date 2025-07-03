<?php

declare(strict_types=1);

namespace App\Exceptions\Json;

use Illuminate\Http\Response;

class IpAddressForbiddenJsonException extends HttpJsonException
{
    public function __construct(string $message = 'Access not allowed.', string $errorCode = 'IpAddressAccessNotAllowed')
    {
        parent::__construct(
            status: Response::HTTP_FORBIDDEN,
            errorCode: $errorCode,
            message: $message
        );
    }
}
