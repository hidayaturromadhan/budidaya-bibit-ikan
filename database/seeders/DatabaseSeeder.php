<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FishSeed;
use App\Models\FishSeedSize;
use App\Models\Stock;
use App\Models\StockMovement;

class DatabaseSeeder extends Seeder
{
    /**
        * Seed the application's database.
        */
    public function run(): void
    {
        // 1. Create Users
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 2. Create Fish Seeds
        $fishes = [
            [
                'name' => 'Ikan Nila Merah Super',
                'category' => 'Ikan Nila',
                'description' => 'Bibit ikan nila merah kualitas unggul yang tahan penyakit, cepat tumbuh, dan daging tebal. Sangat direkomendasikan untuk budidaya intensif maupun tradisional.',
            ],
            [
                'name' => 'Ikan Lele Sangkuriang',
                'category' => 'Ikan Lele',
                'description' => 'Bibit lele strain sangkuriang asli. Laju pertumbuhan sangat cepat, kanibalisme rendah, dan masa panen lebih singkat. Cocok untuk kolam terpal maupun tanah.',
            ],
            [
                'name' => 'Ikan Gurame Soang',
                'category' => 'Ikan Gurame',
                'description' => 'Bibit gurame jenis soang dengan ciri khas dahi menonjol saat dewasa. Pertumbuhan lebih cepat dari gurame biasa, bentuk tubuh memanjang, dan sisik besar.',
            ],
            [
                'name' => 'Ikan Patin Siam',
                'category' => 'Ikan Patin',
                'description' => 'Bibit ikan patin siam asli unggul. Rakus makan, cepat besar, sangat adaptif terhadap berbagai kualitas air. Direkomendasikan untuk keramba atau kolam tanah luas.',
            ],
            [
                'name' => 'Ikan Mas Punten',
                'category' => 'Ikan Mas',
                'description' => 'Bibit ikan mas jenis punten. Karakteristik tubuh bulat pendek, tahan terhadap serangan penyakit Koi Herpes Virus (KHV), daging sangat padat dan enak.',
            ],
        ];

        foreach ($fishes as $fishData) {
            $fish = FishSeed::create($fishData);

            // 3. Create Sizes & Stock for each fish
            $sizes = [
                ['label' => '2-3 cm', 'price_multiplier' => 1],
                ['label' => '3-5 cm', 'price_multiplier' => 1.5],
                ['label' => '5-7 cm', 'price_multiplier' => 2.5],
            ];

            // Base prices
            $basePrice = 0;
            if ($fish->category === 'Ikan Nila') $basePrice = 200;
            if ($fish->category === 'Ikan Lele') $basePrice = 150;
            if ($fish->category === 'Ikan Gurame') $basePrice = 800;
            if ($fish->category === 'Ikan Patin') $basePrice = 300;
            if ($fish->category === 'Ikan Mas') $basePrice = 400;

            foreach ($sizes as $sizeData) {
                $size = FishSeedSize::create([
                    'fish_seed_id' => $fish->id,
                    'size_label' => $sizeData['label'],
                    'price' => $basePrice * $sizeData['price_multiplier'],
                ]);

                // Initial Stock
                $qty = rand(500, 5000);
                Stock::create([
                    'fish_seed_size_id' => $size->id,
                    'quantity' => $qty,
                ]);

                StockMovement::create([
                    'fish_seed_size_id' => $size->id,
                    'type' => 'in',
                    'quantity' => $qty,
                    'note' => 'Stok Awal (Sistem)',
                ]);
            }
        }
    }
}
