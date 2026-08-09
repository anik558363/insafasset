<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['land', 'flat', 'house', 'commercial']);
            $table->enum('listing_type', ['sale', 'rent'])->default('sale');
            $table->decimal('price', 15, 2);
            $table->string('price_unit', 30)->nullable()->comment('e.g. per katha, total');
            $table->decimal('size', 10, 2);
            $table->enum('size_unit', ['katha', 'bigha', 'decimal', 'sft', 'acre'])->default('katha');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('location_text', 255);
            $table->string('division', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('area', 100)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('youtube_link', 255)->nullable();
            $table->enum('status', ['available', 'booked', 'sold', 'rented'])->default('available');
            $table->boolean('featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
