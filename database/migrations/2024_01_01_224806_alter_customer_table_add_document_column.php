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
        Schema::table('tb_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id')->unique();

            $table->foreign('document_id')->references('id')->on('tb_document')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('tb_customer', 'document_id');
    }
};
