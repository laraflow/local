<?php

namespace Laraflow\Local\Seeders;

use Illuminate\Database\Seeder;
use Laraflow\Local\Facades\Local;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->data();

        foreach (array_chunk($data, 200) as $block) {
            set_time_limit(2100);
            foreach ($block as $entry) {
                Local::country()->create($entry);
            }
        }
    }

    private function data()
    {
        return [];
    }
}
