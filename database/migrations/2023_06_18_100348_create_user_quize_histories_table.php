<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_quize_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quize_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('user_answer_option_id');
            $table->unsignedBigInteger('right_option_id');
            $table->tinyInteger('status')->default(0)->comment('0 = wrong, 1 = right');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quize_id')->references('id')->on('quizes')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('user_answer_option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('right_option_id')->references('id')->on('options')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quize_histories');
    }
};
