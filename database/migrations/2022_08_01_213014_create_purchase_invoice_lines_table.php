<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoiceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_invoice_id')->nullable();
            $table->bigInteger('administrator_id')->nullable();
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $table->Integer('quantity')->default(0);
            $table->decimal('unit_price')->default(0);
            $table->decimal('reduction')->default(0);
            $table->decimal('reduction_amount')->default(0);
            $table->decimal('ht_amount')->default(0);
            $table->decimal('tva')->default(0);
            $table->decimal('tva_amount')->default(0);
            $table->decimal('ttc_amount')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('purchase_invoice_lines');
    }
}
