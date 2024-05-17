<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name'=>'Ludovick Konyo',
            'email'=>'developer.ludovic@gmail.com',
            'phone'=>'255746828843',
            'user_ype'=>'supplier',
            'password'=>Hash::make('admin123')
        ];
        User::query()->create($user);
    }
}
