<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('access_level_id'); // تغییر از unsignedBigInteger به unsignedInteger
            $table->foreign('access_level_id')->references('id')->on('access_levels')->onDelete('cascade');
            $table->timestamps();
        });  
        
        DB::table('user_access_levels')->insert([
            'user_id' => '1',
            'access_level_id' => '1',
        ]);         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_access_levels');
    }
};
