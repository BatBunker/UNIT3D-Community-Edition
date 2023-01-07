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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('currency_type');
            $table->string('transaction_id');
            $table->unsignedDecimal('transaction_amount');
            $table->boolean('transaction_verified_by_staff');
            $table->unsignedDecimal('transaction_amount_usd');
            $table->unsignedBigInteger('donation_cycle_id');
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('RESTRICT')
                ->onDelete('CASCADE');
            $table
                ->foreign('donation_cycle_id')
                ->references('id')
                ->on('donations_cycle')
                ->onUpdate('RESTRICT')
                ->onDelete('CASCADE');
        });
    }
};
