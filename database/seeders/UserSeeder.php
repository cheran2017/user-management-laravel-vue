<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
        ->count(10)
        ->create()
        ->each(function ($user) {
            $user->addresses()->createMany([
                \App\Models\Address::factory()->make(['address_type' => 'home'])->toArray(),
                \App\Models\Address::factory()->make(['address_type' => 'work'])->toArray(),
            ]);
        });
    }
}
