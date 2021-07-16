<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount')->comment('決済金額');
            $table->string('stripe_session_id')->index()->comment('Stripe Checkout の Session ID');
            $table->string('stripe_payment_intent_id')->comment('Stripe Checkout で使用される PaymentIntent ID');
            $table->boolean('is_complete')->default(false)->comment('決済が完了してるかどうか');
            $table->foreignId('user_id');
            $table->foreignId('point_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('point_id')->references('id')->on('points');
            $table->unique('stripe_session_id');
            $table->unique('stripe_payment_intent_id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_checkouts');
    }
}
