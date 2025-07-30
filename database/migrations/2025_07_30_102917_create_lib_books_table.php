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
        Schema::create('lib_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('humen_id')->nullable();
            $table->foreignIdFor(\App\Models\LibResource::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\LibPublishing::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('classifier')->nullable()->comment('klassifikator');
            $table->string('name')->comment('nomi');
            $table->string('author')->comment('avtor');
            $table->text('annotation')->nullable()->comment('anotatsiya');
            $table->double('number')->default(0)->comment('soni');
            $table->boolean('is_active')->default(0)->comment('holati');
            $table->unsignedBigInteger('page')->comment('beti');
            $table->string('image')->nullable()->comment('rasmi');
            $table->double('price')->default(0)->comment('narxi');
            $table->date('release_date')->nullable()->comment('chiqqan yili');
            $table->dateTime('add_date')->nullable()->comment('qoshilgan vaqti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_books');
    }
};
