<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->text('description', 100);
            $table->double('price');
            $table->integer('size');
            $table->boolean('status')->default(false);
            $table->integer('unit_number');
            $table->enum('type',config('enum.unit_type'));
            $table->foreignId('floor_id')->constrained('floors');
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
        Schema::dropIfExists('units');
    }
}
