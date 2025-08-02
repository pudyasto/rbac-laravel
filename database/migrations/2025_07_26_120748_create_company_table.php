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
        Schema::create('company', function (Blueprint $table) {
            $table->string('uuid',50)->primary();

            $table->string('code', 10)->unique();
            
            $table->string('business_name',255)->unique();
            
            $table->string('business_address',255)->nullable();

            $table->string('business_phone1',20)->nullable();
            $table->string('business_phone2',20)->nullable();

            $table->string('business_mail1',255)->nullable();
            $table->string('business_mail2',255)->nullable();

            $table->string('owner_name',255)->nullable();
            $table->string('owner_address',255)->nullable();
            $table->string('owner_phone',255)->nullable();
            $table->string('owner_mail',255)->nullable();

            $table->string('status', 20)->nullable();
            
            $table->longText('business_logo')->nullable();

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
        Schema::dropIfExists('company');
    }
};
