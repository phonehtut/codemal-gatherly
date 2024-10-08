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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('image')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('org_name')->nullable();
            $table->string('org_email')->nullable();
            $table->string('org_phone')->nullable();
            $table->string('org_logo')->nullable();
            $table->float('rating');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('limit')->nullable();
            $table->longText('location')->nullable();
            $table->text('plaform')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
