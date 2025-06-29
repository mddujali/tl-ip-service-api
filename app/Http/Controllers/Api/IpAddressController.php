<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Json\IpAddressNotFoundJsonException;
use App\Http\Requests\Api\IpAddress\SaveIpAddressRequest;
use App\Http\Resources\Api\IpAddresses\IpAddressCollection;
use App\Http\Resources\Api\IpAddresses\IpAddressResource;
use App\Models\IpAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IpAddressController extends BaseController
{
    public function index(): IpAddressCollection
    {
        $ipAddresses = IpAddress::query()->get();

        return (new IpAddressCollection($ipAddresses))
            ->setMessage(__('shared.common.success'));
    }

    public function store(SaveIpAddressRequest $request)
    {
        try {
            $ipAddress = IpAddress::query()
                ->create($request->validated());
        } catch (Exception) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return $this->errorResponse(
                status: $status,
                message: __('shared.common.' . $status),
            );
        }

        return (new IpAddressResource($ipAddress))
            ->setMessage(__('shared.common.success'));
    }

    public function show(Request $request)
    {
        try {
            $id = $request->route('ip_address_id');

            $ipAddress = IpAddress::query()->find($id);

            if (!$ipAddress) {
                throw new IpAddressNotFoundJsonException();
            }
        } catch (Exception $exception) {
            if ($exception instanceof IpAddressNotFoundJsonException) {
                return $this->errorResponse(
                    status: $exception->getStatus(),
                    errorCode: $exception->getErrorCode(),
                    message: $exception->getMessage(),
                );
            }

            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return $this->errorResponse(
                status: $status,
                message: __('shared.common.' . $status),
            );
        }

        return (new IpAddressResource($ipAddress))
            ->setMessage(__('shared.common.success'));
    }

    public function update(SaveIpAddressRequest $request)
    {
        try {
            $id = $request->route('ip_address_id');

            $ipAddress = IpAddress::query()->find($id);

            if (!$ipAddress) {
                throw new IpAddressNotFoundJsonException();
            }

            $ipAddress->update($request->validated());
        } catch (Exception $exception) {
            if ($exception instanceof IpAddressNotFoundJsonException) {
                return $this->errorResponse(
                    status: $exception->getStatus(),
                    errorCode: $exception->getErrorCode(),
                    message: $exception->getMessage(),
                );
            }

            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return $this->errorResponse(
                status: $status,
                message: __('shared.common.' . $status),
            );
        }

        return (new IpAddressResource($ipAddress))
            ->setMessage(__('shared.common.success'));
    }
}
