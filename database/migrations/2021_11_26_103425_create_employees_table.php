<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('agency_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Employee::class, 'parent_id')
                ->nullable()
                ->constrained('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
           

            $table->string('name', 100);
            $table->enum('gender', config('enum.genders'));
            $table->string('dob')->nullable();
            $table->integer('level')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('phone_number')->unique();
            $table->string('slug')->nullable();
//            $table->enum('status', config('enum.account_statuses'))->default('enum.account_statuses.pending');
            /*$table->foreignId('area_id')
                ->constrained()->cascadeOnDelete();*/

            $table->string('address');
            $table->string('zip_code', 8);
            $table->string('cnic')->unique();
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
        Schema::dropIfExists('employees');
    }
}
