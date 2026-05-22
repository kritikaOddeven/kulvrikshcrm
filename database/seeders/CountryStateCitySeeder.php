<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountryStateCitySeeder extends Seeder
{
    public function run(): void
    {
        $sqlFiles = [
            public_path('country-state-city/countries.sql'),
            public_path('country-state-city/states.sql'),
            public_path('country-state-city/cities.sql'),
            public_path('country-state-city/districts.sql'),
        ];

        foreach ($sqlFiles as $path) {
            $file = basename($path);

            if (! File::exists($path)) {
                $this->command->error("File not found: {$file}");
                continue;
            }

            $this->command->info("Importing SQL file in chunks: {$file}");

            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                $this->importSqlInChunks($path);

                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                $this->command->info("Imported: {$file}");
            } catch (\Throwable $e) {
                $this->command->error("Error importing {$file}: " . $e->getMessage());
                \Log::error("Error importing {$file}: " . $e->getMessage());
            }
        }
    }

    protected function importSqlInChunks(string $path): void
    {
        $buffer = '';
        $handle = fopen($path, 'r');

        if (! $handle) {
            throw new \Exception("Unable to open file: {$path}");
        }

        while (($line = fgets($handle)) !== false) {
            $trimmedLine = trim($line);

            // Skip comments and empty lines
            if ($trimmedLine === '' || str_starts_with($trimmedLine, '--') || str_starts_with($trimmedLine, '/*')) {
                continue;
            }

            $buffer .= $line;

            // Check if line ends with semicolon = end of a full statement
            if (str_ends_with(trim($line), ';')) {
                DB::unprepared($buffer);
                $buffer = '';
            }
        }

        fclose($handle);
    }

}
