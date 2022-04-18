<?php

namespace Tests\Auth;

use App\Events\LoginEvent;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     */
    public function userCanLoginWhenEmailAndPasswordIsCorrect()
    {
        $password = '123456';
        $user = User::factory()->create([
            User::PASSWORD => $password
        ]);

        $response = $this->post(
            route('v1.login'),
            [
                User::EMAIL => $user->{User::EMAIL},
                User::PASSWORD => $password,
            ]
        );

        $this->assertResponseOk();
        $this->assertIsString($response->response->getOriginalContent()['access_token']);
    }

    /**
     * @test
     */
    public function userCanNotLoginWhenPasswordIsWrong()
    {
        $user = User::factory()->create();

        $response = $this->post(
            route('v1.login'),
            [
                User::EMAIL => $user->{User::EMAIL},
                User::PASSWORD => Str::random(10),
            ]
        );

        $response->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function userGetUnauthorizedResponseWhenEmailDoesNotExist()
    {
        $response = $this->post(
            route('v1.login'),
            [
                User::EMAIL => User::factory()->make()->{User::EMAIL},
                User::PASSWORD => Str::random(10),
            ]
        );

        $response->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function loginEventWillBeDispatchedAfterLoginUser()
    {
        Event::fake();
        $password = '123456';
        $user = User::factory()->create([
            User::PASSWORD => $password
        ]);

        $this->post(
            route('v1.login'),
            [
                User::EMAIL => $user->{User::EMAIL},
                User::PASSWORD => $password,
            ]
        );

        Event::assertDispatched(LoginEvent::class);
    }

    /**
     * @test
     */
    public function LoginEventWillNotBeDispatchedWhenLoginIsNotSuccessful()
    {
        Event::fake();

        $user = User::factory()->create();

        $this->post(
            route('v1.login'),
            [
                User::EMAIL => $user->{User::EMAIL},
                User::PASSWORD => Str::random(10),
            ]
        );

        Event::assertNotDispatched(LoginEvent::class);
    }
}
