<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{

    public function run()
    {
        DB::table('admins')->delete();

        $admin = Admin::create([
            'name'     => 'admin',
            'email'    => 'ashraktamin678@gmail.com',
            'phone'    => '01095425446',
            'password' => bcrypt('12345678'),
            'api_token'       =>NULL
        ]);

        $token =  $admin->createToken('admin-api', ['role:admin'])->plainTextToken;

        $admin->update([
            'api_token'       =>  $token
        ]);
    }
}
