<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            User::ID => $this->{User::ID},
            User::FIRST_NAME => $this->{User::FIRST_NAME},
            User::LAST_NAME => $this->{User::LAST_NAME},
            User::EMAIL => $this->{User::EMAIL},
            User::EMAIL_VERIFIED_AT => $this->{User::EMAIL_VERIFIED_AT},
            User::ROLE => $this->{User::ROLE},
            User::CREATED_AT => $this->{User::CREATED_AT},
            User::UPDATED_AT => $this->{User::UPDATED_AT},
        ];
    }
}
