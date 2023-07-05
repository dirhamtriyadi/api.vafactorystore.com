<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                "user_id" => 1,
                "name" => "dashboard",
            ],
            [
                "user_id" => 1,
                "name" => "master-jenis-pembayaran",
            ],
            [
                "user_id" => 1,
                "name" => "master-jenis",
            ],
            [
                "user_id" => 1,
                "name" => "data-customer",
            ],
            [
                "user_id" => 1,
                "name" => "data-barang",
            ],
            [
                "user_id" => 1,
                "name" => "penjualan",
            ],
            [
                "user_id" => 1,
                "name" => "lihat-penjualan",
            ],
            [
                "user_id" => 1,
                "name" => "uang-kas",
            ],
            [
                "user_id" => 1,
                "name" => "data-users",
            ],
            [
                "user_id" => 1,
                "name" => "laporan-uangkas",
            ],
            [
                "user_id" => 1,
                "name" => "tracking",
            ],
            [
                "user_id" => 1,
                "name" => "orders",
            ],
            [
                "user_id" => 1,
                "name" => "order-transaction",
            ],
            [
                "user_id" => 1,
                "name" => "order-tracking",
            ]
        ]);
    }
}
