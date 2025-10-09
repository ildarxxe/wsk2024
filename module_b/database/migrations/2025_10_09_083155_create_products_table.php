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
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger("GTIN");
            $table->bigInteger("company_id")->unsigned()->nullable();
            $table->foreign("company_id")->references("id")->on("companies");
            $table->string('name');
            $table->string('name_fr');
            $table->string('description');
            $table->string('description_fr');
            $table->string('brand_name');
            $table->string('country');
            $table->text('image_url')->nullable();
            $table->float('gross_weight');
            $table->float('net_weight');
            $table->string('weight_unit');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
