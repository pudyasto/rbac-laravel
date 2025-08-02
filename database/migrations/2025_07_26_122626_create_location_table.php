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
        Schema::create('location', function (Blueprint $table) {
            $table->string('uuid',50)->primary();
            $table->string('company_uuid',50)->nullable();
            $table->foreign('company_uuid')->references('uuid')->on('company');

            $table->string('code', 10)->unique();
            $table->string('name',255)->unique();
            $table->string('lat_long',255)->nullable();
            $table->string('is_main', 20)->nullable();

            $table->string('status', 20)->nullable();

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
        Schema::dropIfExists('location');
    }
};
