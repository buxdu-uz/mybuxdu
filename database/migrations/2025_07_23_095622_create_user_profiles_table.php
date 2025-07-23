<?php

use App\Domain\Classifiers\Models\ClassifierOption;
use App\Domain\Departments\Models\Department;
use App\Domain\Specialities\Models\Speciality;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->index()
                ->unique()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Department::class)
                ->nullable()
                ->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('full_name')->index();
            $table->string('short_name',100);
            $table->string('first_name',100)->nullable();
            $table->string('second_name',100)->nullable();
            $table->string('third_name',100)->nullable();
            $table->string('passport')->nullable();
            $table->unsignedBigInteger('pinfl')->nullable();
            $table->unsignedInteger('year_of_enter')->nullable();
            $table->string('contract_number')->nullable();
            $table->string('decree_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('contract_date')->nullable();
            $table->date('decree_date')->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_gender')->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_academic_degree')->nullable()->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_academic_rank')->nullable()->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_employment_form')->nullable()->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_employment_staff')->nullable()->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_staff_position')->nullable()->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_employee_status')->nullable()->nullable();
            $table->foreignIdFor(ClassifierOption::class,'h_employee_type')->nullable()->nullable();
            $table->string('hash',64)->nullable();
            $table->json('tutorGroups')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
