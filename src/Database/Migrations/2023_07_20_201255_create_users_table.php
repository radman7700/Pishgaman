<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('User name');
            $table->string('last_name')->nullable()->comment('User last name');
            $table->string('username')->unique()->comment('User username');
            $table->string('email')->unique()->comment('User email address');
            $table->timestamp('email_verified_at')->nullable()->comment('Date of email verification');
            $table->string('phone')->nullable()->comment('User phone number');
            $table->timestamp('phone_verified_at')->nullable()->comment('Date of phone number verification');
            $table->string('password')->comment('User password (hashed)');
            $table->timestamp('password_verified_at')->nullable()->comment('Date of password verification');
            $table->boolean('is_active')->default(true)->comment('User account active status');
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_until')->nullable();            
            $table->timestamps(); // 'created_at' and 'updated_at' fields
            $table->softDeletes(); // استفاده از softDeletes()
        });

        // Creating a hashed password for the default admin user
        $defaultPassword = Hash::make('admin123');

        DB::table('users')->insert([
            'name' => 'Default Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => $defaultPassword,
            'is_active' => true,
            'is_blocked'=>false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
