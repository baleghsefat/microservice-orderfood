<?php

namespace App\Models;

use App\Interfaces\Models\RestaurantUserInterface;
use Illuminate\Database\Eloquent\Model;

class RestaurantUser extends Model implements RestaurantUserInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        self::USER_ID,
        self::RESTAURANT_ID,
    ];
}
