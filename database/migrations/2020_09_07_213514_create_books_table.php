<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('category_id');
            $table->string('title');
            $table->string('edition')->nullable();
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->year('year_publish')->nullable();
            $table->unsignedInteger('num_copy');
            $table->unsignedInteger('available_copy');
            $table->unsignedInteger('borrow_copy')->default(0);
            $table->timestamps();

            //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
