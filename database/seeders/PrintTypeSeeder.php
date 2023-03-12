<?php

namespace Database\Seeders;

use App\Models\PrintType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PrintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrintType::insert([
            [
                'name' => 'BASIC',
                'price' => 110000,
                'description' => 'Design baju Jersey non-printing, Number nameset logo polyflex, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'HALF PRINTING',
                'price' => 135000,
                'description' => 'Design baju Jersey printing depan belakang, Number nameset logo printing, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'FULL PRINTING',
                'price' => 150000,
                'description' => 'Design baju Jersey full printing depan belakang, Number nameset logo printing, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'EXCLUSIVE',
                'price' => 170000,
                'description' => 'Design baju Jersey full printing depan belakang, Number nameset logo polyflex, Celana non-printing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
