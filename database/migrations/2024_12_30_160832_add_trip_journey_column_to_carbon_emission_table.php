<?php

use App\Lib\RouteType;
use App\Lib\TripJourney;
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
            $table->string('trip_journey')->after('user_id')->default(TripJourney::DAILY);
            $table->string('journey_start_date')->after('trip_journey')->default(date('Y-m-d'));
            $table->string('journey_end_date')->after('journey_start_date')->default(date('Y-m-d'));
            $table->string('custom_week')->after('journey_end_date')->nullable();
            $table->string('custom_month')->after('custom_week')->nullable();
            $table->string('semester_type')->after('custom_month')->nullable();
            $table->string('semester_year')->after('semester_type')->nullable();
            $table->string('custom_date')->after('semester_year')->nullable();
            $table->string('custom_year')->after('custom_date')->nullable();
            $table->string('route_type')->after('custom_year')->default(RouteType::RETURN);
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
            $table->drop([
                'trip_journey',
                'journey_start_date',
                'journey_end_date',
                'custom_week',
                'custom_month',
                'semester_type',
                'semester_year',
                'custom_date',
                'custom_year',
                'route_type',
            ]);
        });
    }
};
