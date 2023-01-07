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
            $table->integer('user_id');
            $table->string('currency_type');
            $table->string('transaction_id');
            $table->unsignedDecimal('transaction_amount');
            $table->boolean('transaction_verified_by_staff');
            $table->unsignedDecimal('transaction_amount_usd');
            $table->integer('donation_cycle_id');
            $table->timestamps();

            $table
                ->foreign('user_id', 'fk_donations_users1')
                ->references('id')
                ->on('users')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
            $table
                ->foreign(
                    'donation_cycle_id', 
                    'fk_donations_donation_cycle_id_1')
                ->references('id')
                ->on('donations_cycle')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });
    }
};
