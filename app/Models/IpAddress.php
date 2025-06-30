<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use HasFactory;

    protected $table = 'ip_addresses';

    protected $fillable = [
        'user_id',
        'ip_address',
        'label',
        'comment',
    ];
}
