<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carbon_emission', function (Blueprint $table) {
            $table->string('origin_address')->after('user_id');
            $table->string('destination_address')->after('starting_latlng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carbon_emission', function (Blueprint $table) {
            $table->drop(['origin_address', 'destination_address']);
        });
    }
};
