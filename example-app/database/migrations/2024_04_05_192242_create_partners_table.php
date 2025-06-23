<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('partners', function (Blueprint $table) {
        $table->id();
        $table->string('venue_type')->nullable();
        $table->string('venue_name');
        $table->string('address');
        $table->string('website')->nullable();
        $table->string('venue_phone_number');
        $table->string('venue_city');
        $table->string('venue_country');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
