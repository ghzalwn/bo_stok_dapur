<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('address_title');
            $table->string('recipient_name');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('address_3');
            $table->foreignUuid('province_id')->constrained('provinces');
            $table->foreignUuid('city_id')->constrained('cities');
            $table->foreignUuid('district_id')->constrained('districts');
            $table->foreignUuid('subdistrict_id')->constrained('subdistricts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
}
