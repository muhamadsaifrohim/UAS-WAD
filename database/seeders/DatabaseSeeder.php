<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Users (akun untuk README / penilai) ---
        $admin = User::create([
            'name' => 'Admin Gudang',
            'email' => 'admin@gudang.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@gudang.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // --- Categories ---
        $cats = collect(['Elektronik', 'Alat Tulis', 'Makanan & Minuman', 'Perabot'])
            ->mapWithKeys(fn ($n) => [$n => Category::create(['name' => $n])]);

        // --- Suppliers ---
        $s1 = Supplier::create(['name' => 'PT Maju Jaya', 'phone' => '081234567890', 'address' => 'Jl. Sudirman No. 10, Jakarta']);
        $s2 = Supplier::create(['name' => 'CV Sumber Rejeki', 'phone' => '082198765432', 'address' => 'Jl. Gatot Subroto No. 5, Bandung']);
        $s3 = Supplier::create(['name' => 'UD Berkah Abadi', 'phone' => '085611223344', 'address' => 'Jl. Diponegoro No. 22, Surabaya']);

        // --- Products (stok awal 0, diisi lewat transaksi "in" di bawah) ---
        $items = [
            ['Elektronik', $s1, 'ELK-001', 'Keyboard USB', 150000, 5],
            ['Elektronik', $s1, 'ELK-002', 'Mouse Wireless', 120000, 5],
            ['Elektronik', $s1, 'ELK-003', 'Kabel HDMI 2m', 45000, 10],
            ['Alat Tulis', $s2, 'ATK-001', 'Pulpen Hitam (box)', 30000, 10],
            ['Alat Tulis', $s2, 'ATK-002', 'Kertas A4 (rim)', 55000, 20],
            ['Makanan & Minuman', $s3, 'MKN-001', 'Air Mineral 600ml (dus)', 42000, 15],
            ['Makanan & Minuman', $s3, 'MKN-002', 'Kopi Sachet (box)', 38000, 10],
            ['Perabot', $s2, 'PRB-001', 'Kursi Kantor', 750000, 3],
        ];

        $products = [];
        foreach ($items as [$cat, $sup, $sku, $name, $price, $min]) {
            $products[$sku] = Product::create([
                'category_id' => $cats[$cat]->id,
                'supplier_id' => $sup->id,
                'sku' => $sku,
                'name' => $name,
                'price' => $price,
                'stock' => 0,
                'min_stock' => $min,
            ]);
        }

        // --- Stock transactions (stok produk ikut diperbarui) ---
        $movements = [
            ['ELK-001', 'in', 20, 'Stok awal', $admin],
            ['ELK-002', 'in', 15, 'Stok awal', $admin],
            ['ELK-003', 'in', 8, 'Stok awal', $admin],
            ['ATK-001', 'in', 40, 'Stok awal', $admin],
            ['ATK-002', 'in', 60, 'Stok awal', $admin],
            ['MKN-001', 'in', 30, 'Stok awal', $admin],
            ['MKN-002', 'in', 25, 'Stok awal', $admin],
            ['PRB-001', 'in', 6, 'Stok awal', $admin],
            ['ELK-001', 'out', 8, 'Dikirim ke cabang Bandung', $staff],
            ['ATK-002', 'out', 45, 'Permintaan divisi HR', $staff],
            ['PRB-001', 'out', 4, 'Pesanan kantor baru', $staff],
            ['ELK-003', 'out', 2, 'Penggantian kabel rusak', $staff],
        ];

        foreach ($movements as $i => [$sku, $type, $qty, $note, $user]) {
            $product = $products[$sku];

            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'type' => $type,
                'quantity' => $qty,
                'note' => $note,
                'transaction_date' => now()->subDays(count($movements) - $i),
            ]);

            $type === 'in'
                ? $product->increment('stock', $qty)
                : $product->decrement('stock', $qty);
        }
    }
}
