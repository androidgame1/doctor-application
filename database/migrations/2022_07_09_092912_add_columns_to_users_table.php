<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('administrator_id')->nullable();
            $table->string('cin')->after('name')->nullable();
            $table->string('fullname')->after('cin')->nullable();
            $table->string('address')->after('email')->nullable();
            $table->string('phone')->after('address')->nullable();
            $table->string('city')->after('phone')->nullable();
            $table->integer('role')->after('city')->default(0);
            $table->string('logo')->after('role')->default(0);
            $table->integer('isvalidate')->after('role')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
