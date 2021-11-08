<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hasTable('posts')) {
			Schema::create('posts', function (Blueprint $table) {
				$table->id();
				$table->string('title')->nullable();
				$table->string('category')->nullable();
				$table->text('content')->nullable();
				$table->text('image')->nullable();
				$table->timestamps();
				$table->timestamp('deleted_at')->nullable();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('posts');
	}
}
