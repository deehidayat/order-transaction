<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('invoice_no');
            $table->foreign('invoice_no')->references('invoice_no')->on('orders')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->string('payment_date');
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('transfered_by');

            $table->decimal('amount', 20, 4);
            $table->string('file_url');

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
        Schema::drop('order_payments');
    }
}
