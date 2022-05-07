<?php

namespace App\Interfaces\Models;

interface RestaurantInterface extends BaseModelInterface
{
    const TABLE = 'restaurants';
    const NAME = 'name';
    const LAT = 'lat';
    const LNG = 'lng';
    const ADDRESS = 'address';
    const USER_IDS = 'user_ids';
}
