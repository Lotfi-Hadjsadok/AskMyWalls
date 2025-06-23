<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'price' => $this->faker->numberBetween(100000, 2000000),
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'area' => $this->faker->numberBetween(500, 5000),
            'type' => $this->faker->randomElement(['House', 'Apartment', 'Condo']),
            'status' => $this->faker->randomElement(['For Sale', 'For Rent', 'Sold']),
            'year_built' => $this->faker->year,
            'features' => $this->faker->words(5),
            'images' => [
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl()
            ]
        ];
    }
}
