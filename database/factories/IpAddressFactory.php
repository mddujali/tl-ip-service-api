<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\IpAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IpAddress>
 */
class IpAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'ip_address' => $this->faker->ipv4(),
            'label' => $this->faker->word(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
