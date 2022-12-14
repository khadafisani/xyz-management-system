<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->references('id')->on('installations');
            $table->double('amount');
            $table->string('note')->nullable();
            $table->tinyInteger('status');
            $table->string('file_path');
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
        Schema::dropIfExists('installation_payments');
    }
};
