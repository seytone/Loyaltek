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
        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->string('type');
            $table->text('imageUrl');
            $table->integer('cmc')->default(0);
            $table->string('rarity')->nullable();
            $table->json('manaCost')->nullable();
            $table->json('colorIdentity')->nullable();
            $table->string('multiverseid')->nullable();
            $table->string('set')->nullable();
            $table->string('setName')->nullable();
            $table->string('artist')->nullable();
            $table->json('types')->nullable();
            $table->json('subtypes')->nullable();
            $table->integer('power')->nullable();
            $table->text('text')->nullable();
            $table->text('flavor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};
