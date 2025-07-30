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
        Schema::create('lib_bbks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_id')->nullable()->index();
            $table->unsignedBigInteger('code')->comment('bbk kodi');
            $table->string('name')->comment('bbk nomi');
            $table->text('info')->comment('bbk info');
            $table->boolean('is_active')->comment('bbk holati');
            $table->timestamps();

            $table->foreign('sub_id')->references('id')->on('lib_bbks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_bbks');
    }
};
