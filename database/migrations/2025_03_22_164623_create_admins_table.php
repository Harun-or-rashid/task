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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['Admin', 'Manager'])->default('Admin');
            $table->bigInteger('employee_id')->nullable();
            $table->boolean('manage_organization')->default(false);
            $table->boolean('manage_team')->default(false);
            $table->boolean('manage_employee')->default(false);
            $table->boolean('manage_maneger')->default(false);
            $table->boolean('manage_report')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
