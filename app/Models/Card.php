<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'season',
        'version',
        'img',
        'pack',
        'description'
    ];

    public static function getAllCardsOrdered(): Collection
    {
        return Card::query()->select('*')->orderBy('id','asc')->get();
    }
}
