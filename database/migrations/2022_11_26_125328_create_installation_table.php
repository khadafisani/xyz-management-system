<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Enums\InstallationStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(InstallationStatus::SUBMITTED->value);
            $table->text('note')->nullable();
            $table->string('file_path');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('service_id')->references('id')->on('services');
            $table->double('installation_fee');
            $table->text('address');
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
        Schema::dropIfExists('installations');
    }
};
