<?php

namespace Database\Factories;

use App\Models\Import;
use App\Models\ImportRowError;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImportRowError>
 */
class ImportRowErrorFactory extends Factory
{
    protected $model = ImportRowError::class;

    public function definition(): array
    {
        return [
            'import_id' => Import::factory(),
            'row_number' => 1,
            'row_data' => ['name' => 'Invalid player'],
            'error_message' => 'Invalid row data.',
        ];
    }
}
