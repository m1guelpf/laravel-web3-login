<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWalletColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('wallet')->nullable();
            
            $routes = config('web3.routes', []);
            if (in_array('register', $routes)) {
                $table->string('name')->nullable()->change();
                $table->string('email')->nullable()->change();
                $table->string('password')->nullable()->change();
            }
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
            $table->dropColumn('wallet');

            $routes = config('web3.routes', []);
            if (in_array('register', $routes)) {
                $table->string('name')->change();
                $table->string('email')->change();
                $table->string('password')->change();
            }
        });
    }
}
