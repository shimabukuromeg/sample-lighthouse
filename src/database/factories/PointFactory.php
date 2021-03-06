<?php

namespace Database\Factories;

use App\Models\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Point::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'point' => $this->faker->randomNumber(),
            'price' => $this->faker->randomNumber(),
            'stripe_product_id' => 'prod_JpE2H7dCwFys7h',
        ];
    }
}
