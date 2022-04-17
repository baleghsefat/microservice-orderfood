<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Models\User;

class LoginRequest extends BaseRequest
{
    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            User::EMAIL => ['required', 'email'],
            User::PASSWORD => ['required', 'string', 'max:32'],
        ];
    }
}
