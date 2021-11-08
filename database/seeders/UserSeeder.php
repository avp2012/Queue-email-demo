<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$items = [
			[
				'id' => 1,
				'name' => 'admin',
				'email' => 'admin@admin.com',
				'password' => \Hash::make('admin'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
		];

		foreach ($items as $key => $item) {
			User::updateOrCreate(['id' => $item['id']], $item);
		}
	}
}
