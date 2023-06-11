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
        Schema::create('quizes', function (Blueprint $table) {
            $table->id();
            $table->string('quize_name')->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = Deactive, 1 = Active');
            $table->integer('expire_time')->comment('in Minitue');
            $table->string('qr_code')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizes');
    }
};
