<?php

namespace App\Rules;

use App\Services\Rpc\ClientRpcService;
use Illuminate\Contracts\Validation\Rule;
use Exception;
use Illuminate\Support\Facades\Log;

class UserIdRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute Attribute.
     * @param mixed $value Value.
     *
     * @return bool
     * @throws Exception Exception.
     */
    public function passes($attribute, $value): bool
    {
        try {
            $rpc = new ClientRpcService();

            return $rpc->userIdValidator($value);
        } catch (Exception $e) {
            Log::error($e);

            throw new Exception('A problem has occurred. Try again in a few minutes.');
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return ':attribute is not valid.';
    }
}
