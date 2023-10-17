<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// DB,Hashクラスのインポート
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('owners')->insert([
            [
                'name'=>'川嶋 静奈',
                'email'=>'Shizuna_Kawashima@brohtyjhx.if',
                'password'=>Hash::make('CRKW7dSX'),
                'created_at'=> '2021/11/10 11:20:31'
            ],
            [
                'name'=>'新倉 浩一',
                'email'=>'kouichi_niikura@hyhwq.dw',
                'password'=>Hash::make('yw8HEKw2'),
                'created_at'=> '2021/11/10 11:20:32'
            ],
            [
                'name'=>'中林 二菜',
                'email'=>'anakabayashi@tlzv.rz',
                'password'=>Hash::make('test987213'),
                'created_at'=> '2021/11/10 11:20:33'
            ],
        ]);
    }
}
