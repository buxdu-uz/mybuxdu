<?php

use App\Domain\Classifiers\Models\ClassifierOption;
use App\Domain\Departments\Models\Department;
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
        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class)
                ->nullable()
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('code',30);
            $table->string('name');
            $table->string('h_locality_type')->nullable();
            $table->string('h_education_type')->nullable();
            $table->string('h_bachelor_speciality')->nullable();
            $table->string('h_master_speciality')->nullable();
            $table->string('doctorate_speciality')->nullable();
            $table->string('h_speciality_ordinatura')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialities');
    }
};
