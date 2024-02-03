<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->string('uuid',50)->primary();

            $table->string('name');
            $table->string('link');
            $table->string('description')->nullable();
            $table->string('is_active', 10)->default('Aktif');

            $table->string('created_by', 50)->nullable();
            $table->foreign('created_by')->references('uuid')->on('users');

            $table->string('updated_by', 50)->nullable();
            $table->foreign('updated_by')->references('uuid')->on('users');

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
        Schema::dropIfExists('modules');
    }
}
