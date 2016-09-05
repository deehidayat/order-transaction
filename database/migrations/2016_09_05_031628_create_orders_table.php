<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('invoice_no')->unique()->index();
            $table->datetime('expire_date');
            $table->string('notes');

            $table->string('name');
            $table->string('email');
            $table->string('phone_number');

            $table->text('address');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('sub_district');
            $table->integer('postal_code');

            $table->decimal('subtotal', 20, 4);

            $table->string('coupon_code');
            $table->string('coupon_type');
            $table->decimal('coupon_amount', 20, 4);
            $table->decimal('coupon_total', 20, 4);

            $table->string('shipping_name');
            $table->string('shipping_price');
            $table->string('shipping_no');

            $table->decimal('total', 20, 4);
            $table->enum('status', ['pending_payment', 'rejected', 'paid', 'ready_for_shipment', 'shipped', 'completed']);

            $table->timestamps();
        });

        Schema::create('order_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('invoice_no');
            $table->foreign('invoice_no')->references('invoice_no')->on('orders')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->string('code');
            $table->string('name');
            $table->decimal('price', 20, 4);
            $table->integer('quantity');

            $table->decimal('total', 20, 4);

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
        Schema::drop('order_details');
        Schema::drop('orders');
    }
}
