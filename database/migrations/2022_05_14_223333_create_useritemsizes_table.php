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
        Schema::create('useritemsizes', function (Blueprint $table) {
            $table->foreignId('itemsize_id')->constrained('itemsizes');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();

            $table->primary(['itemsize_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('useritemsizes');
    }
};
