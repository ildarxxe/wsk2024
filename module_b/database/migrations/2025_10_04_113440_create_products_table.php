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
            $table->bigInteger("GTIN")->unsigned()->unique();
            $table->bigInteger("company_id")->unsigned()->nullable();
            $table->foreign("company_id")->references("id")->on("companies");
            $table->string("name", 255);
            $table->string("french_name", 255);
            $table->text("description");
            $table->text("french_description");
            $table->text("image_url")->nullable();
            $table->string("brand_name", 255);
            $table->string("origin_country", 255);
            $table->float("gross_weight");
            $table->float("net_weight");
            $table->string("weight_unit", 55);
            $table->boolean("hidden")->default(false);
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
