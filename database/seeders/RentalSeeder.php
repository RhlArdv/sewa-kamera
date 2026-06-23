<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Bayar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories
        $categories = [
            [
                'kategori_name' => 'DSLR',
                'slug' => 'dslr',
            ],
            [
                'kategori_name' => 'Mirrorless',
                'slug' => 'mirrorless',
            ],
            [
                'kategori_name' => 'Action Camera',
                'slug' => 'action-camera',
            ],
            [
                'kategori_name' => 'Aksesoris',
                'slug' => 'aksesoris',
            ],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $category = Category::create($cat);
            $categoryIds[$cat['slug']] = $category->id_kategori;
        }

        // 2. Seed Products
        $products = [
            [
                'produk_name' => 'Canon EOS 3000D',
                'unit' => 3,
                'price' => 15000,
                'description' => 'Kamera DSLR entry-level yang cocok untuk pemula. Mudah digunakan dengan hasil foto yang jernih.',
                'category_id' => $categoryIds['dslr'],
                'fotos' => ['canon-3000d.jpg'],
            ],
            [
                'produk_name' => 'Fujifilm X-A3',
                'unit' => 2,
                'price' => 20000,
                'description' => 'Kamera mirrorless bergaya retro dengan layar flip-up 180 derajat untuk mempermudah selfie.',
                'category_id' => $categoryIds['mirrorless'],
                'fotos' => ['fuji-xa3.jpg'],
            ],
            [
                'produk_name' => 'GoPro Hero 10 Black',
                'unit' => 4,
                'price' => 25000,
                'description' => 'Action camera tangguh, anti air, dan memiliki stabilisasi video HyperSmooth 4.0 terbaik.',
                'category_id' => $categoryIds['action-camera'],
                'fotos' => ['gopro-10.jpg'],
            ],
            [
                'produk_name' => 'Sony Alpha A6400',
                'unit' => 2,
                'price' => 30000,
                'description' => 'Kamera mirrorless berspesifikasi tinggi dengan autofocus super cepat dan perekaman video 4K HDR.',
                'category_id' => $categoryIds['mirrorless'],
                'fotos' => ['sony-a6400.jpg'],
            ],
            [
                'produk_name' => 'Tripod Beike Q-999H',
                'unit' => 5,
                'price' => 5000,
                'description' => 'Tripod kokoh multifungsi yang bisa diubah menjadi monopod, cocok untuk segala kebutuhan foto/video.',
                'category_id' => $categoryIds['aksesoris'],
                'fotos' => ['tripod-beike.jpg'],
            ],
        ];

        foreach ($products as $prod) {
            $fotos = $prod['fotos'];
            unset($prod['fotos']);

            $product = Product::create($prod);

            foreach ($fotos as $foto) {
                ProductGallery::create([
                    'produk_id' => $product->id_produk,
                    'foto' => $foto,
                ]);
            }
        }

        // 3. Seed Bayar Methods
        $bayarMethods = [
            [
                'jenis_bayar' => 'Midtrans DP',
                'keterangan' => 'Pembayaran Uang Panjar (DP) secara otomatis menggunakan kartu kredit, transfer bank, atau e-wallet melalui Midtrans.',
            ],
            [
                'jenis_bayar' => 'Cash',
                'keterangan' => 'Pembayaran langsung di toko sewa kamera secara tunai.',
            ],
            [
                'jenis_bayar' => 'Transfer Bank',
                'keterangan' => 'Transfer manual ke rekening bank sewa kamera.',
            ],
        ];

        foreach ($bayarMethods as $bayar) {
            Bayar::create($bayar);
        }
    }
}
