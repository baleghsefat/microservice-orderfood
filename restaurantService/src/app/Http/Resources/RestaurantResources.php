<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            Restaurant::ID => $this->{Restaurant::ID},
            Restaurant::NAME => $this->{Restaurant::NAME},
            Restaurant::ADDRESS => $this->{Restaurant::ADDRESS},
            Restaurant::CREATED_AT => $this->{Restaurant::CREATED_AT},
            Restaurant::UPDATED_AT => $this->{Restaurant::UPDATED_AT},
        ];
    }
}
