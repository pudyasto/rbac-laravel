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
        Schema::create('location_photo', function (Blueprint $table) {
            $table->string('uuid',50)->primary();
            $table->string('location_uuid',50)->nullable();
            $table->foreign('location_uuid')->references('uuid')->on('location');
            
            $table->longText('photo')->nullable();
            $table->string('is_main', 20)->nullable();

            $table->string('created_by', 50)->nullable();

            $table->string('updated_by', 50)->nullable();

            $table->string('deleted_by', 50)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_photo');
    }
};
