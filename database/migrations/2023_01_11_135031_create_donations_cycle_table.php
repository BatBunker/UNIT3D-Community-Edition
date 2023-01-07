<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations_cycle', function (Blueprint $table) {
            $table->id();
            $table->boolean('open');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('amount_wanted_usd');
            $table->unsignedInteger('amount_received_usd')->default(0);
            $table->timestamps();
        });
    }
};
