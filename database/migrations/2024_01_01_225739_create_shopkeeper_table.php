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
        Schema::create('tb_shopkeeper', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->unsignedBigInteger('document_id');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('tb_document')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_shopkeeper');
    }
};
