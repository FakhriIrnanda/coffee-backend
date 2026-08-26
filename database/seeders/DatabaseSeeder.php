<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::where('email', 'admin@mercys.com')->update(['role' => 'admin']);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        // Seeders above insert rows with explicit ids, which on Postgres
        // does not advance the id sequence, so the next auto-generated
        // insert can collide with an already-seeded id. Sync it back up.
        if (DB::getDriverName() === 'pgsql') {
            foreach (['categories', 'products'] as $table) {
                DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), COALESCE((SELECT MAX(id) FROM {$table}), 1))");
            }
        }
    }
}
