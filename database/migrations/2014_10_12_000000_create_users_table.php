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
        Schema::create('users', function (Blueprint $table) {
            $table->string('uuid',50)->primary();
            
            $table->string('nik')->nullable();
            $table->string('name');
            $table->string('username', 15)->unique();

            $table->string('gender', 10)->nullable();
            $table->string('department', 50)->nullable();
            $table->string('status', 20)->nullable();

            $table->string('email')->unique();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->longText('photo')->nullable();

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
        Schema::dropIfExists('users');
    }
};
