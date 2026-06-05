<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->integer('building_id')->default(1);
            $table->string('title');
            $table->integer('area');

            $table->decimal('living_area', 6, 2)->nullable();

            $table->integer('rooms');
            $table->integer('floor');

            $table->boolean('has_balcony')->default(false);
            $table->decimal('ceiling_height', 4, 2)->nullable();
            $table->string('finishing')->nullable();

            $table->bigInteger('price')->nullable();
            $table->string('status')->default('free');
            $table->integer('zone_number')->default(1);

            $table->string('image')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
