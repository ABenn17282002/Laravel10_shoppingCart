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
            'name'=>'大島 建司',
            'email'=>'iooshima@zlhakv.jhj',
            'password'=>Hash::make('dteYNF25'),
            'created_at'=> '2023/10/17 17:30:30'
        ]);
    }
}
