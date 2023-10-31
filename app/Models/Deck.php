<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'type',
        'imageUrl',
        'cmc',
        'rarity',
        'manaCost',
        'colorIdentity',
        'multiverseid',
        'set',
        'setName',
        'artist',
        'types',
        'subtypes',
        'power',
        'text',
        'flavor',
    ];

    /**
	 * The attributes that are guarded.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
}
