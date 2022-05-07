<?php

namespace App\Models;

use App\Interfaces\Models\RestaurantUserInterface;
use Illuminate\Database\Eloquent\Model;

class RestaurantUser extends Model implements RestaurantUserInterface
{
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = [
        self::USER_ID,
        self::RESTAURANT_ID,
    ];

    /**
     * @param int $restaurantId RestaurantId.
     * @param array $userIds UserIds.
     * @return void
     */
    public static function sync(int $restaurantId, array $userIds = []): void
    {
        self::query()->where(self::RESTAURANT_ID, $restaurantId)->delete();
        if (empty($userIds)) {
            return;
        }

        $data = [];
        foreach ($userIds as $userId) {
            $data[] = [RestaurantUser::RESTAURANT_ID => $restaurantId, RestaurantUser::USER_ID => $userId];
        }

        self::query()->insert($data);
    }
}
