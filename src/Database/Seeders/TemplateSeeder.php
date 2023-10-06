<?php

namespace Pishgaman\Pishgaman\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('templates')->insert([
            [
                'name' => 'UnderConstruction',
                'description' => 'This website template is currently under construction.',
                'type' => 'user',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wafi_Admin',
                'description' => 'This is the admin template.',
                'type' => 'admin',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ورودی‌های دیگر به صورت دلخواه
        ]);
    }
}
