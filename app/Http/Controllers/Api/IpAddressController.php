<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\IpAddresses\IpAddressCollection;
use App\Models\IpAddress;
use Illuminate\Http\Request;

class IpAddressController extends BaseController
{
    public function index(): IpAddressCollection
    {
        $ipAddresses = IpAddress::query()->get();

        return (new IpAddressCollection($ipAddresses))
            ->setMessage(__('shared.common.success'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }
}
