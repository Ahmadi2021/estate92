<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->enum('type', config('enum.purposes'));
            $table->string('name');
            $table->enum('property_type', config('enum.property_types'));
            $table->string('address');
            $table->integer('size');
            $table->double('price');
            $table->enum('status', config('enum.property_statuses'));
            $table->integer('no_of_bed');
            $table->integer('no_of_bathroom');
            $table->text('description');
            $table->boolean('is_active')->default(false);
            $table->foreignId('employee_id')->constrained('employees');
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
        Schema::dropIfExists('properties');
    }
}
