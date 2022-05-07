<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use App\Rules\UserIdRule;

class SyncRestaurantUsersRequest extends BaseRequest
{
    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            Restaurant::USER_IDS => ['sometimes', 'array'],
            Restaurant::USER_IDS . '.*' => [
                'required',
                'integer',
                'min:0',
                'distinct',
                'bail',
                new UserIdRule(),
            ],
        ];
    }
}
