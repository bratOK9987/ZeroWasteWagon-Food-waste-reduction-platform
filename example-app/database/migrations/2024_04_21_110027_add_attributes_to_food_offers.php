<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('food_offers', function (Blueprint $table) {
            $table->string('cuisine_type')->nullable();
            $table->integer('caloric_content')->nullable();
        });
    }

    public function down()
    {
        Schema::table('food_offers', function (Blueprint $table) {
            $table->dropColumn(['cuisine_type', 'caloric_content']);
        });
    }
};
