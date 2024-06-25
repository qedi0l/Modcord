<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class UserRequest extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'text',
        'season',
        'state',
        'ip_address',
        'contacts',
        'response',
    ];
    protected $hidden = [
        'uuid',
    ];

    public static function getAllRequests(): Collection
    {
        return UserRequest::query()->select('*')->orderBy('state')->get();
    }

    
}
