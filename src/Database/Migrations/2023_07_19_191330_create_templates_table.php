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
        Schema::create('templates', function (Blueprint $table) {
            // Primary key for the table
            $table->increments('id')->comment('The primary key for the templates table.');

            // Name of the template (should be in English)
            $table->string('name')->comment('The name of the template (should be in English).');

            // Description of the template (nullable)
            $table->string('description')->nullable()->comment('The description of the template.');

            // Type of the template (admin or user)
            $table->string('type', 5)->comment('The type of the template. Possible values: admin (0) or user (1).');

            // Indicates if the template is active (1) or not active (0)
            $table->tinyInteger('active')->default('0')->comment('Indicates if the template is active (1) or not active (0).');

            // Timestamps for created_at and updated_at columns
            $table->timestamps();
        });

        DB::table('templates')->insert([
            'name' => 'Wafi_Admin',
            'description' => 'قالب مدیریتی',
            'type' => 'admin',
            'active' => 0,
        ]); 
        DB::table('templates')->insert([
            'name' => 'first',
            'description' => 'قالب مدیریتی فرست',
            'type' => 'admin',
            'active' => 0,
        ]);
        DB::table('templates')->insert([
            'name' => 'nextable',
            'description' => 'قالب مدیریتی nextable',
            'type' => 'admin',
            'active' => 1,
        ]);                
        DB::table('templates')->insert([
            'name' => 'UnderConstruction',
            'description' => 'قالب در دست ساخت',
            'type' => 'user',
            'active' => 1,
        ]);               
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the templates table if it exists
        Schema::dropIfExists('templates');
    }
};
