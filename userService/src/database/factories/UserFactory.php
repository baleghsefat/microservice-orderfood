<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            User::FIRST_NAME => $this->faker->firstName,
            User::LAST_NAME => $this->faker->lastName,
            User::EMAIL => $this->faker->unique->email,
            User::ROLE => $this->faker->randomElement(User::ROLES),
            User::PASSWORD => 123456, // It will be bcrypt in the user model.
        ];
    }
}
