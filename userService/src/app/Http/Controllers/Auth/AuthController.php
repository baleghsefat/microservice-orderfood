<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request Request.
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->select([User::ID, User::FIRST_NAME, User::LAST_NAME, User::EMAIL, User::ROLE])
            ->where(User::EMAIL, $request->get(User::EMAIL))
            ->first();

        if ($user === null) {
            return $this->getResponse(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $token = JWTAuth::customClaims($user->toArray())
            ->attempt([
                User::EMAIL => $request->get(User::EMAIL),
                User::PASSWORD => $request->get(User::PASSWORD),
            ]);

        if (!$token) {
            return $this->getResponse(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        event(new LoginEvent($user));

        return $this->respondWithToken($token);
    }

    /**
     * @param string $token Token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 3600
        ]);
    }
}
