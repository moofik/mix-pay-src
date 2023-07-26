<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('donation_type')->comment('donation type');
            $table->string('currency')->comment('payment currency');
            $table->decimal('payment_amount')->comment('payment amount');
            $table->string('payment_method')->comment('recipient issuer bank');
            $table->string('tokens_amount')->nullable()->comment('recipient issuer bank');
            $table->string('recipient_address')->nullable()->comment('recipient bank address');
            $table->string('attachment')->nullable()->comment('payment confirmation attachment');

            $table->softDeletesTz();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
