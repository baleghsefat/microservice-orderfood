<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::query()
            ->select([User::FIRST_NAME,User::LAST_NAME,User::EMAIL,User::ROLE])
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

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        dd(auth()->user());
    }
}
