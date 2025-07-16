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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->foreignId('added_by')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('size_id')->nullable();
            $table->string('unit')->nullable();
            $table->tinyInteger('is_featured')->default(2);
            $table->tinyInteger('is_todays_deal')->default(2);
            $table->tinyInteger('is_variant')->default(2);
            $table->tinyInteger('is_stock')->default(2);
            $table->string('thumbnail_img')->nullable();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->tinyInteger('is_short_description')->default(1);
            $table->integer('stock')->nullable();
            $table->double('cost_price')->nullable();
            $table->double('sell_price')->nullable();
            $table->integer('minimum_purchase_qty')->nullable();
            $table->string('sku')->nullable();
            $table->integer('discount')->nullable();
            $table->string('discount_type', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->longText('tags')->nullable();
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
        Schema::dropIfExists('products');
    }
};
