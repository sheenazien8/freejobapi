<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('company_size');
            $table->text('description');
            $table->string('languages');
            $table->string('address');
            $table->string('phone');
            $table->string('website', 64)->nullable();
            $table->string('facebook', 64)->nullable();
            $table->string('instagram', 64)->nullable();
            $table->string('twitter', 64)->nullable();
            $table->string('work_time', 64)->nullable();
            $table->string('wear_style', 64)->nullable();
            $table->string('tunjangan')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
