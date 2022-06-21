<?php

namespace Database\Factories;

use App\Models\Usertype;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsertypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usertype::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word(5),
            'description' => $this->faker->paragraph(1),
        ];
    }
}
