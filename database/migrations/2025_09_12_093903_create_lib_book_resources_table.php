<?php

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
        Schema::create('lib_book_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Domain\Libraries\Books\Models\LibBook::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('humen_id')->nullable()->comment('humen id');
            $table->unsignedBigInteger('in_whom_id')->nullable()->comment('kimda');
            $table->boolean('status')->default(true)->comment('holati');
            $table->string('add_date')->nullable()->comment('add date');
            $table->string('oh_date')->nullable()->comment('oh date');
            $table->string('arrival_date')->nullable()->comment('kelgan vaqti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_book_resources');
    }
};
