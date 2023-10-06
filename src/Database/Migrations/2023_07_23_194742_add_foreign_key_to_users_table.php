<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('current_access_level_id')->nullable()->after('blocked_until');
            $table->foreign('current_access_level_id')->references('id')->on('access_levels')->onDelete('set null');
        });

        DB::table('users')->where('id',1)->update([
            'current_access_level_id' => '1',
        ]); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
