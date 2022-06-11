<?php

namespace Database\Factories;

use App\Enums\DonationTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'=>$this->faker->firstName(),
            'middle_name'=>$this->faker->lastName(),
            'last_name'=>$this->faker->lastName(),
            'date_of_baptism'=>$this->faker->dateTimeBetween('-10 years'),
            'membership_status'=>$this->faker->randomElement(DonationTypeEnum::cases()),
            'dob'=>$this->faker->date(),
        ];
    }
}
