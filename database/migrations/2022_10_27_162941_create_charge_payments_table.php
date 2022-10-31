<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('administrator_id')->nullable();
            $table->bigInteger('charge_id')->nullable();
            $table->date('date')->nullable();
            $table->decimal('given_amount')->decimal(0);
            $table->decimal('remaining_amount')->decimal(0);
            $table->string('way_of_payment')->nullable();
            $table->text('remark')->nullable();
            $table->text('justification')->nullable();
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
        Schema::dropIfExists('charge_payments');
    }
}
