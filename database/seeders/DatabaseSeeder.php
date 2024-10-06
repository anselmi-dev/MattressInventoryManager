<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        settings()->set('stock:days', 10);
    
        settings()->set('stock:media:days', 10);

        settings()->set('order:email', 'anselmi@infinety.es');

        $this->call([
            UserAndRoleSeeder::class,
            ProductTypesSeeder::class,
        ]);

        Artisan::call('cache:clear');
    }
}
