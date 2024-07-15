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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->integer('Product_Set')->default(0);
            $table->integer('Profile_Set')->default(0);
            $table->integer('System_Users_Set')->default(0);
            $table->integer('Permissions_Set')->default(0);
            $table->timestamps();

            // $table->foreign('permission_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
