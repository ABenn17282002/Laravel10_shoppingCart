<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// DB,Hashクラスのインポート
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>Hash::make('test98721'),
            'created_at'=> '2021/11/10 11:20:30'
        ]);
    }
}
