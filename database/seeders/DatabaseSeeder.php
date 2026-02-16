<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Ticket\CategorySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    try {


        $this->call([
            CategorySeeder::class,
        ]);

        User::factory()->create([
          'name' => 'Test User',
          'email' => 'test@example.com',
          'password' => bcrypt('test'),
        ]);


        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);

        User::factory(10)->create();



    }catch (\Exception $exception){
        print("Database seeding failed: {$exception->getMessage()}");
    }

    }
}
