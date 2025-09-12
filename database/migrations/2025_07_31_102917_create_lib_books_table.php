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
            $table->foreignIdFor(\App\Domain\Libraries\Resources\Models\LibResourceType::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Domain\Libraries\Publishings\Models\LibPublishing::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Domain\Libraries\Bbks\Models\LibBbk::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->text('name')->comment('nomi');
            $table->text('author')->comment('avtor');
            $table->text('annotation')->nullable()->comment('anotatsiya');
            $table->double('number')->default(0)->comment('soni');
            $table->boolean('is_active')->default(0)->comment('holati');
            $table->unsignedBigInteger('page')->comment('beti');
            $table->string('image')->nullable()->comment('rasmi');
            $table->double('price')->default(0)->comment('narxi');
            $table->string('release_date')->nullable()->comment('chiqqan yili');
            $table->string('add_date')->nullable()->comment('qoshilgan vaqti');
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
