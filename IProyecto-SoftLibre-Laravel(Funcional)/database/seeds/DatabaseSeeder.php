<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		DB::table('users')->insert(array(
			'first_name'=>'root',
			'last_name'=>'root',
			'email'=>'root@root.com',
			'type'=>true,
			'password' => Hash::make('root'),
			'remember_token'=>'RfaAyqWzpp2YmoAvfBchh1dzJdMWhCUbdJmoYqOTVJp8gum0wW2NURiDBUb9',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));
	}
}
