<?php

namespace App\Http\Requests;

use App\Models\Restaurant;

class RestaurantRequest extends BaseRequest
{
    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            Restaurant::NAME => ['required', 'string', 'max:255'],
            Restaurant::ADDRESS => ['required', 'string', 'max:512'],
        ];
    }
}
