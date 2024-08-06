<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $imageDirectory = database_path('seeders/images');

        $vouchers = [
            ['nama' => 'Voucher 1', 'foto' => '1.jpg', 'kategori' => 'Elektronik', 'status' => true],
            ['nama' => 'Voucher 2', 'foto' => '2.jpg', 'kategori' => 'Makanan', 'status' => true],
            ['nama' => 'Voucher 3', 'foto' => '13.jpg', 'kategori' => 'Makanan', 'status' => true],
            ['nama' => 'Voucher 4', 'foto' => '4.jpg', 'kategori' => 'Fashion', 'status' => true],
            ['nama' => 'Voucher 5', 'foto' => '18.jpg', 'kategori' => 'Alat Masak', 'status' => true],
            ['nama' => 'Voucher 6', 'foto' => '17.jpg', 'kategori' => 'Makanan', 'status' => true],
            ['nama' => 'Voucher 7', 'foto' => '19.jpg', 'kategori' => 'Fashion', 'status' => true],
        ];

        foreach ($vouchers as $voucher) {
            // Create a unique filename for each image
            $imagePath = 'vouchers/' . Str::random(10) . '_' . $voucher['foto'];

            // Copy the image to the storage directory
            Storage::disk('public')->put($imagePath, file_get_contents($imageDirectory . '/' . $voucher['foto']));

            // Create a voucher with the image
            DB::table('vouchers')->insert([
                'nama' => $voucher['nama'],
                'foto' => $imagePath,
                'kategori' => $voucher['kategori'],
                'status' => $voucher['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
