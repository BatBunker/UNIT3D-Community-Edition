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
            $table->string('receiving_account_details');
            $table->string('transaction_id');
            $table->unsignedDecimal('transaction_amount');
            $table->string('donor_remark')->nullable();
            $table->enum('transaction_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('verifier_remark')->default('');
            $table->string('verified_by')->nullable();
            $table->unsignedDecimal('transaction_amount_usd')->default(0);
            $table->unsignedBigInteger('donation_cycle_id')->nullable();
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
