<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
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
        Schema::create('access_level_menu', function (Blueprint $table) {
            $table->increments('id');
            
            // Foreign Key for access_levels table
            $table->unsignedInteger('access_level_id');
            $table->foreign('access_level_id')
                  ->references('id')
                  ->on('access_levels')
                  ->onDelete('cascade');
            
            // Foreign Key for menus table
            $table->unsignedInteger('menu_id');
            $table->foreign('menu_id')
                  ->references('id')
                  ->on('menus')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });    
        
        DB::table('access_level_menu')->insert([
            'access_level_id' => '1',
            'menu_id' => '1',
        ]); 
        DB::table('access_level_menu')->insert([
            'access_level_id' => '1',
            'menu_id' => '2',
        ]);
        DB::table('access_level_menu')->insert([
            'access_level_id' => '1',
            'menu_id' => '3',
        ]);
        DB::table('access_level_menu')->insert([
            'access_level_id' => '1',
            'menu_id' => '4',
        ]);
        DB::table('access_level_menu')->insert([
            'access_level_id' => '1',
            'menu_id' => '5',
        ]);  
        DB::table('access_level_menu')->insert([
            'access_level_id' => '1',
            'menu_id' => '6',
        ]);                                             
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_level_menu');
    }
};
