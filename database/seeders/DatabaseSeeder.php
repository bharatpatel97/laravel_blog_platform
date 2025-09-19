<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user) {
            Post::factory(5)->create(['user_id' => $user->id]);
        });
    }
}
