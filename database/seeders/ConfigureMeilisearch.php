<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigureMeilisearch extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('meilisearch')->updateSettings([
            'searchableAttributes' => [
                'name',
                'email',
            ],
            'filterableAttributes' => [
            ],
        ]);
    }
}
