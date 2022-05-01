<?php

namespace App\Observers;

use App\Jobs\PublishGlobalJob;
use App\Models\Restaurant;

class RestaurantObserver
{
    public bool $afterCommit = true;

    /**
     * @param Restaurant $restaurant Restaurant.
     * @return void
     */
    public function created(Restaurant $restaurant): void
    {
        $this->publishGlobally($restaurant, 'create');
    }

    /**
     * @param Restaurant $restaurant Restaurant.
     * @return void
     */
    public function deleted(Restaurant $restaurant): void
    {
        $this->publishGlobally($restaurant, 'delete');
    }

    /**
     * @param Restaurant $restaurant Restaurant.
     * @param string $event Event.
     * @return void
     */
    private function publishGlobally(Restaurant $restaurant, string $event): void
    {
        $data = $restaurant->toArray();
        $data['event'] = $event;

        dispatch(new PublishGlobalJob($data));
    }
}
