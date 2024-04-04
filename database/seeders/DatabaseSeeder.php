<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\File;
use App\Models\UserRequest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$WD/M.gnDyAMVCebOV.iX4.ch0TQT0VuDVcJkPahRwsHdsUx6FU5rG',
            'remember_token' =>'KZHbkozmTViBdDiVvqco9uqtj1VkqfpDsvoo4osTQZrn3wt7WA8yPph2iH2P',
            'created_at' => '2024-03-13 20:00:19',
            'updated_at' => '2024-03-13 20:00:19',
        ]);

        //UserRequest::factory(1)->create();
        
    }
}
