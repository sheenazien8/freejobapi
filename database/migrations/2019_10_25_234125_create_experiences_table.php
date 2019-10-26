<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('freelancer_id')->unsigned();
            $table->string('company_name');
            $table->date('start_work');
            $table->date('end_work')->nullable();
            $table->boolean('currently_work_here')->default(false);
            $table->string('position');
            $table->double('salary');
            $table->text('job_description')->nullable();

            $table->foreign('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
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
        Schema::dropIfExists('experiences');
    }
}
