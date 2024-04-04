<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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
}
