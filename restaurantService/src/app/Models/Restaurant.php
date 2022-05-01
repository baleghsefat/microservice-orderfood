<?php

namespace App\Models;

use App\Interfaces\Models\RestaurantInterface;
use App\Observers\RestaurantObserver;
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
        self::ADDRESS,
    ];


    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        self::observe([RestaurantObserver::class]);
    }
}
