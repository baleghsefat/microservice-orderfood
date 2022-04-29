<?php

namespace App\Interfaces\Models;

interface RestaurantUserInterface extends BaseModelInterface
{
    const TABLE = 'restaurant_user';
    const USER_ID = 'user_id';
    const RESTAURANT_ID = 'restaurant_id';
}
