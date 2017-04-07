<?php

use Illuminate\Database\Seeder;

class blogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = [
        	[
        		'tanggal'=>'1995-07-12', 

        		'judul'=>'Belajar Laravel 5.4 seru!', 

        		'isi'=>'Now, when you generate a form element, like a text input, the models value matching the fields name will automatically be set as the field value.'
        	],
        	[
        		'tanggal'=>'1994-04-21', 

        		'judul'=>'Nuklir Korut!', 
        		
        		'isi'=>'Agar file migration diatas bisa dijalankan, kita harus melakukan perubahan pada file database/seeds/DatabaseSeeder.php'
        	]
        ];

        // insert into db

        DB::table('blog')->insert($store);

    }
}
