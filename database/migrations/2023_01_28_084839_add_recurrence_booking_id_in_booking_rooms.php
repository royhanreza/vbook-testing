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
        Schema::table('booking_rooms', function (Blueprint $table) {
            $table->integer('recurrence_booking_id')->nullable()->after('recurrence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_rooms', function (Blueprint $table) {
            $table->dropColumn('recurrence_booking_id');
        });
    }
};
