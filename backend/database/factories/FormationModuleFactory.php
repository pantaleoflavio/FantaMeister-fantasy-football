<?php

namespace Database\Factories;

use App\Models\FormationModule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FormationModule>
 */
class FormationModuleFactory extends Factory
{
    protected $model = FormationModule::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->bothify('#-#-#');

        return [
            'name' => $name,
            'label' => $name,
            'is_active' => true,
        ];
    }
}
