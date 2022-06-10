<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
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
            $table->string('title');
            $table->text('description');
            $table->string('author');
            $table->unsignedBigInteger('owner');
            $table->tinyInteger('status')->default(0)->comment('0: available, 1: borrowing, 2: not available');
            $table->unsignedBigInteger('assignee')->nullable();
            $table->timestamps();

            $table->foreign('owner')->references('id')->on('users');
            $table->foreign('assignee')->references('id')->on('users');

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
};
