<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('food_offers', function (Blueprint $table) {
            $table->json('dietary_restrictions')->nullable();
        });
    }

    public function down()
    {
        Schema::table('food_offers', function (Blueprint $table) {
            $table->dropColumn('dietary_restrictions');
        });
    }
};
