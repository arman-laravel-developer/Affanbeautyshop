<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_pixel')->nullable();
            $table->tinyInteger('facebook_pixel_status')->default(1);
            $table->string('google_analytics')->nullable();
            $table->tinyInteger('google_analytics_status')->default(1);
            $table->string('tag_manager')->nullable();
            $table->tinyInteger('tag_manager_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_analytics');
    }
};
