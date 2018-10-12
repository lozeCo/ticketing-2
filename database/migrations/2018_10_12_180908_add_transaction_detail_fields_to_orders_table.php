<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionDetailFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->string('confirmation_code');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('payment_gateway');
            $table->string('payment_gateway_reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('confirmation_code');
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_email');
            $table->dropColumn('payment_gateway');
            $table->dropColumn('payment_gateway_reference');
        });
    }
}
