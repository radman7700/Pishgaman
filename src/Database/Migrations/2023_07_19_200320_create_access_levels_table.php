<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('access_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps(); // استفاده از timestamps()
            $table->softDeletes(); // استفاده از softDeletes()
        });        

        DB::table('access_levels')->insert([
            'name' => 'مدیریت سامانه',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('access_levels')->insert([
            'name' => 'کاربر عادی',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_levels');
    }
};
