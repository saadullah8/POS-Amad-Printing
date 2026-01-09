<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     User::create([
'name'=>'super admin',
'email'=>'admin@gmail.com',
'password'=>Hash::make('12121212'),
'role'=>1,
     ]

     );


     User::create([
        'name'=>'admin',
        'email'=>'admin1@gmail.com',
        'password'=>Hash::make('12345678'),
        'role'=>2,
     ]);
    }
}
