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
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('set null');
            $table->string('order')->nullable();
            $table->string('name'); 
            $table->string('route')->nullable();
            $table->text('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });   
        
        DB::table('menus')->insert([
            'order' => '1',
            'name' => 'UserInterface',
            'icon' => 'fa fa-home',
            'type' => 'header',
        ]);   
        DB::table('menus')->insert([
            'order' => '1',
            'parent_id' => '1',
            'name' => 'home',
            'route' => 'home',
            'icon' => 'fa fa-home',
        ]);  
        DB::table('menus')->insert([
            'order' => '2',
            'name' => 'SystemManagement',
            'icon' => 'fa fa-setting',
            'type' => 'header',
        ]);  
        DB::table('menus')->insert([
            'order' => '1',
            'parent_id' => '3',
            'name' => 'AccessLevel',
            'route' => 'PAdminAccessLevel',
            'url' => 'AccessLevel',
            'icon' => 'fa fa-lock',
        ]);   
        DB::table('menus')->insert([
            'order' => '2',
            'parent_id' => '3',
            'name' => 'Users',
            'route' => 'PAdminUsers',
            'url' => 'Users',
            'icon' => 'fa fa-users',
        ]);  
        DB::table('menus')->insert([
            'order' => '3',
            'parent_id' => '3',
            'name' => 'Histories',
            'route' => 'PAdminHistory',
            'url' => 'historylist',
            'icon' => 'fa fa-history',
        ]);                                      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
