<?php

declare(strict_types=1);

namespace App\Exceptions\Json;

use Illuminate\Http\Response;

final class IpAddressNotFoundJsonException extends HttpJsonException
{
    public function __construct(string $message = 'IP Address not found.', string $errorCode = 'IpAddressNotFound')
    {
        parent::__construct(
            status: Response::HTTP_NOT_FOUND,
            errorCode: $errorCode,
            message: $message
        );
    }
}
