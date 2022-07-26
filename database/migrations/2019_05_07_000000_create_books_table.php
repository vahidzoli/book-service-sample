<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
        });

        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn')->unique();
            $table->string('title');
            $table->text('description');
        });

        Schema::create('author_book', function (Blueprint $table) {
            $table->unsignedbigInteger('author_id');
            $table->unsignedbigInteger('book_id');

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        Schema::create('book_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('book_id');
            $table->unsignedbigInteger('user_id');
            $table->tinyInteger('review')->unsigned();
            $table->text('comment');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('book_reviews');
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('books');
        Schema::dropIfExists('authors');
    }
}
