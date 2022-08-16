<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_lines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('activity_id')->nullable();
            $table->bigInteger('administrator_id')->nullable();
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $table->Integer('quantity')->default(0);
            $table->decimal('unit_price')->default(0);
            $table->decimal('reduction')->default(0);
            $table->decimal('reduction_amount')->default(0);
            $table->decimal('ht_amount')->default(0);
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
        Schema::dropIfExists('activity_lines');
    }
}