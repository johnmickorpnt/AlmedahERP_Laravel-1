<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('p_invoice_id')->unique;
            $table->string('p_receipt_id');
            $table->foreign('p_receipt_id')->references('p_receipt_id')->on('purchase_receipt');
            $table->date('date_created');
            $table->json('due_date_of_payment');
            $table->float('mode_payment');
            $table->string('paid_amount');
            $table->string('pi_status');
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
        Schema::dropIfExists('purchase_invoice');
    }
}