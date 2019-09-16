<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('user_id');
            $table->date('date')->nullable(false);
            $table->time('time')->nullable(false);
            $table->longText('description')->nullable();
            $table->integer('hours')->nullable(false)->default(0);
            $table->integer('minutes')->nullable(false)->default(0);
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('time_logs');
    }
}
