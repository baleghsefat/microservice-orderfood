<?php

namespace App\Models;

use App\Interfaces\Models\CategoryInterface;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements CategoryInterface
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        self::TITLE,
    ];

    public static function boot()
    {
        parent::boot();
        self::observe([CategoryObserver::class]);
    }
}
