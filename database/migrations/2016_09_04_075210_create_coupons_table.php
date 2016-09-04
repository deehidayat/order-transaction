<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code')->unique()->index();
            $table->string('description');
            $table->float('amount')->unasigned();
            $table->enum('amount_type', ['percentage', 'money']);
            $table->integer('stock')->unasigned();
            $table->date('valid_from');
            $table->date('valid_until');
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
        Schema::drop('coupons');
    }
}
