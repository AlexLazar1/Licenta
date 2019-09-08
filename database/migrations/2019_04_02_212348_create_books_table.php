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
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ISBN');
            $table->integer('library_id')->unsigned();
            $table->foreign('library_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('image_url')->nullable();
            $table->string('publication_day')->nullable();
            $table->string('publication_month')->nullable();
            $table->string('publication_year')->nullable();
            $table->string('publisher')->nullable();
            $table->string('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('books');
    }
}
