<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => str('admin'),
            'email' => str('admin@mail.ru'),
            'password' => Hash::make('password')
        ]);
        $user->roles()->attach([
            'role_id' => Role::where('name', 'admin')->first()->id
        ]);
    }
}
