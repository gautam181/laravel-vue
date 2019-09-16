<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uploaded_by')->nullable(false);
            $table->string('filename')->nullable(false);
            $table->unsignedBigInteger('project_id')->nullable(false);
            $table->unsignedBigInteger('ticket_id')->default(0);
            $table->string('knownas')->nullable(false);
            $table->text('description')->nullable(true);
            $table->integer('size')->default(0);
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('uploaded_by')->references('id')->on('users');
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
        Schema::dropIfExists('files');
    }
}
