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
        Schema::create('customer', function (Blueprint $table) {
            $table->string('uuid',50)->primary();
            
            $table->string('id_number',50)->unique();
            $table->string('id_type',10)->default('KTP')->comment('KTP, SIM');
            $table->longText('id_photo')->nullable();

            $table->string('name',255)->unique();
            $table->string('phone',20)->nullable();
            $table->string('address',255)->nullable();
            $table->string('city',255)->nullable();


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
        Schema::dropIfExists('customer');
    }
};
