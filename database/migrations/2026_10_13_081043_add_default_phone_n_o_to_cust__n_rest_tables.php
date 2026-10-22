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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone_no')->default("0000000000");
        }); // Added missing closing brace and parenthesis

        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('phone_no')->default("0000000000");
        });
    }

    
    public function down(): void
    {
        // Drop the columns completely to reverse the "up" action
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('phone_no');
        });
       
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('phone_no');
        });
    }
};
