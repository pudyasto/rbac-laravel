<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('uuid',50)->primary();

            $table->string('lang', 4)->default('id');
            $table->smallInteger('menu_order')->default('0');

            $table->string('menu_header')->nullable();
            $table->string('menu_name');
            $table->string('description');
            $table->string('link');
            $table->string('icon', 50);
            
            $table->string('main_uuid', 50)->nullable();

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
        Schema::dropIfExists('menus');
    }
}
