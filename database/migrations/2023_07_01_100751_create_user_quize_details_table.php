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
        Schema::create('user_quize_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quize_id');
            $table->tinyInteger('status')->default(0)->comment('0 = Pending, 1 = Atttemted,2 = Declined,3 = Completed');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quize_id')->references('id')->on('quizes')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quize_details');
    }
};
