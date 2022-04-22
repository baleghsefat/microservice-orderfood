<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            Category::ID => $this->{Category::ID},
            Category::TITLE => $this->{Category::TITLE},
            Category::CREATED_AT => $this->{Category::CREATED_AT},
            Category::UPDATED_AT => $this->{Category::UPDATED_AT},
        ];
    }
}
