<?php

namespace App\Models;

use App\Interfaces\Models\RestaurantInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model implements RestaurantInterface
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        self::NAME,
        self::LAT,
        self::LNG,
        self::ADDRESS,
    ];
}
