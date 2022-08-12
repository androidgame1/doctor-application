<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('series')->nullable();
            $table->bigInteger('administrator_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->date('date')->nullable();
            $table->string('remark')->nullable();
            $table->decimal('reduction_total_amount')->nullable();
            $table->decimal('ht_total_amount')->default(0);
            $table->decimal('tva_total_amount')->default(0);
            $table->decimal('ttc_total_amount')->default(0);
            $table->integer('status')->default(0);            
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
        Schema::dropIfExists('purchase_invoices');
    }
}
