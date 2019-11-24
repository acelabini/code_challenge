<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlayerResource
 * @package App\Models
 * @property  int id
 * @property int player_id
 * @property array player_information
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 */
class Player extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'player_id',
        'player_information'
    ];

    protected $casts = [
        'player_information' => 'array'
    ];
}