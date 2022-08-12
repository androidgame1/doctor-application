<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('administrator_id')->nullable();
            $table->bigInteger('secretary_id')->nullable();
            $table->string('cin')->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->integer('weight')->default(0);
            $table->integer('height')->default(0);
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
        Schema::dropIfExists('Patients');
    }
}
