<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::all()->random();
        $randomAssignee = User::all()->random();

        return [
            'title' => $this->faker->lexify('Book ?????'),
            'description' => $this->faker->text(),
            'author' => $this->faker->name(),
            'owner' => $user->id,
            'status' => 1,
            'assignee' => $randomAssignee->id
        ];
    }
}
