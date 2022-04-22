<?php

namespace App\Models;

use App\Interfaces\Models\CategoryInterface;
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
}
