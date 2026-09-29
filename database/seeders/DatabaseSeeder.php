<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@jbgame.com'],
            [
                'name' => 'Administrator JB Game',
                'password' => Hash::make('admin123'),
                'phone' => '081234567890',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Buat Akun Customer Contoh
        $customer = User::firstOrCreate(
            ['email' => 'user@jbgame.com'],
            [
                'name' => 'Gamer Sultan',
                'password' => Hash::make('password'),
                'phone' => '089876543210',
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // 3. Kategori Game
        $categoriesData = [
            [
                'name' => 'Mobile Legends',
                'slug' => 'mobile-legends',
                'icon' => null,
                'description' => 'Jual beli akun MLBB Mythic, Glory, Immortal, Full Skin Collector & Legend.',
            ],
            [
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'icon' => null,
                'description' => 'Akun FF Old, Bundle Cobra, AK Draco Blue Flame, SG Rapper, Master.',
            ],
            [
                'name' => 'Roblox',
                'slug' => 'roblox',
                'icon' => null,
                'description' => 'Akun Blox Fruits Max Level, Godhuman, Mythical Fruit, Robux Avatar.',
            ],
            [
                'name' => 'FC Mobile',
                'slug' => 'fc-mobile',
                'icon' => null,
                'description' => 'Akun EA Sports FC Mobile OVR 100+, Full Icon, Ronaldo & Messi.',
            ],
            [
                'name' => 'GTA V Online',
                'slug' => 'gta-v',
                'icon' => null,
                'description' => 'Akun GTA Online Modded / High Level, Uang Milyaran, Full Supercar & Property.',
            ],
            [
                'name' => 'Valorant',
                'slug' => 'valorant',
                'icon' => null,
                'description' => 'Akun Valorant Rank Radiant/Immortal, Vandal Kuronami, Prime, Reaver.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Buat Akun Game Contoh
        $products = [
            [
                'category_id' => $categories['mobile-legends']->id,
                'seller_id' => $admin->id,
                'title' => 'MLBB Mythical Immortal - 180 Skin (2 Collector + 1 Legend Gusion)',
                'slug' => 'mlbb-mythical-immortal-180-skin',
                'price' => 750000,
                'short_description' => 'WR 68%, Emblem Max, 2 Skin Collector, 1 Legend Gusion, Monsep Clean Bind.',
                'description' => '<p>Spesifikasi Akun:</p><ul><li>Rank Sekarang: Mythical Immortal 120 Stars</li><li>Total Hero: 124 (Full)</li><li>Total Skin: 180 (Legend Gusion, Collector Granger & Natalia)</li><li>Emblem: All Max Level 60</li><li>Status Bind: Moonton Sepaket (Email bawaan diberikan seutuhnya)</li><li>Minus: Tidak ada minus, akun pribadi anti hackback garansi seumur hidup.</li></ul>',
                'thumbnail' => null,
                'account_username' => 'mlbb_immortal_01',
                'account_password' => 'PassGlory2026!',
                'account_additional_info' => 'Login via Moonton. Email login: immortal01@mailgame.com (Password email sama). Silakan ganti kata sandi setelah verifikasi berhasil.',
                'status' => 'available',
            ],
            [
                'category_id' => $categories['free-fire']->id,
                'seller_id' => $admin->id,
                'title' => 'Akun FF Old Season 2 - Bundle Cobra Max + SG 2 OPM & Rapper',
                'slug' => 'ff-old-s2-bundle-cobra-max',
                'price' => 520000,
                'short_description' => 'Akun Old Era S2, Evo Gun Cobra Max Level 7, SG 2 Rapper & OPM, Vault Rame.',
                'description' => '<p>Akun Idaman Kolektor FF:</p><ul><li>Season: Old Season 2 (Elite Pass S2 Aktif)</li><li>Evo Gun: MP40 Cobra Max Lv 7, AK Draco Lv 5</li><li>Skin Senjata: SG 2 Ungu (Rapper), SG 2 OPM, M1887 One Punch Man</li><li>Bind Akun: Facebook Kosongan (Email pemulihan belum ada)</li></ul>',
                'thumbnail' => null,
                'account_username' => 'ff_cobra_s2',
                'account_password' => 'CobraFF#2026',
                'account_additional_info' => 'Login via Akun Facebook. Username: ff_cobra_s2@fbmail.com. Setelah login harap tambahkan nomor HP Anda sendiri.',
                'status' => 'available',
            ],
            [
                'category_id' => $categories['roblox']->id,
                'seller_id' => $admin->id,
                'title' => 'Roblox Blox Fruits Max Lv 2550 - Godhuman + Sanguine Art + Kitsune Perm',
                'slug' => 'roblox-blox-fruits-max-kitsune-perm',
                'price' => 380000,
                'short_description' => 'Max Level 2550, Permanent Kitsune & Portal, CDK, TTK, Soul Guitar, 1500 Robux sisa.',
                'description' => '<p>Detail Akun Roblox Blox Fruits:</p><ul><li>Level: 2550 (Max)</li><li>Fighting Style: Godhuman + Sanguine Art Max Mastery</li><li>Melee & Sword: Cursed Dual Katana, True Triple Katana, Hallow Scythe</li><li>Permanent Fruits: Kitsune Perm & Portal Perm</li><li>Beli: 50.000.000+, Fragment: 120.000+</li><li>Sisa Robux di Akun: 1.500 Robux</li></ul>',
                'thumbnail' => null,
                'account_username' => 'BloxKing_2026',
                'account_password' => 'KitsuneGod999',
                'account_additional_info' => 'Login langsung di Roblox. Akun unverified email & tanpa pin, pembeli bisa langsung bind email & nomer HP pembeli 100% aman.',
                'status' => 'available',
            ],
            [
                'category_id' => $categories['fc-mobile']->id,
                'seller_id' => $admin->id,
                'title' => 'EA Sports FC Mobile OVR 103 - Full Icon R9, Gullit, Zidane, Maldini',
                'slug' => 'fc-mobile-ovr-103-full-icon',
                'price' => 290000,
                'short_description' => 'Squad OVR 103, Striker R9 Ronaldo Nazario Red Rank, Gullit, Koin 80 Juta.',
                'description' => '<p>Akun Kompetitif FC Mobile:</p><ul><li>OVR Utama: 103</li><li>Striker: Ronaldo R9 (Rank Merah, Level 25)</li><li>Midfield: Ruud Gullit, Zinedine Zidane, Patrick Vieira</li><li>Defense: Paolo Maldini & Van Dijk</li><li>Sisa Koin Pasar: 80.000.000 Coins</li><li>Bind: Akun EA Account (Ganti email mudah)</li></ul>',
                'thumbnail' => null,
                'account_username' => 'fcmobile_r9_sultan',
                'account_password' => 'FCSultan2026!',
                'account_additional_info' => 'Login via EA Account. Email bawaan disertakan. Setelah masuk silakan ganti ke email pribadi.',
                'status' => 'available',
            ],
            [
                'category_id' => $categories['valorant']->id,
                'seller_id' => $admin->id,
                'title' => 'Valorant Ascendant 2 - Kuronami Vandal, Reaver Knife, Prime Phantom',
                'slug' => 'valorant-ascendant-kuronami-vandal',
                'price' => 620000,
                'short_description' => 'Server Asia (SG), Vandal Kuronami & Prime, Melee Reaver Karambit, VP sisa 850.',
                'description' => '<p>Spesifikasi Akun Valorant:</p><ul><li>Current Rank: Ascendant 2</li><li>Peak Rank: Immortal 1</li><li>Skin Unggulan: Kuronami Vandal (Full Upgrade), Reaver Karambit, Prime Phantom, Ion Sheriff</li><li>Server: Asia / Singapore (Low Ping Indo)</li><li>Status Email: First Email (Handled clean)</li></ul>',
                'thumbnail' => null,
                'account_username' => 'val_kuronami_sg',
                'account_password' => 'RadiantAim2026@',
                'account_additional_info' => 'Login Riot Games. Email asli dan akun riot diberikan satu paket. Pembeli dapat mengubah email dan riot tag.',
                'status' => 'available',
            ],
            [
                'category_id' => $categories['gta-v']->id,
                'seller_id' => $admin->id,
                'title' => 'GTA V Online PC - Rank 350, Cash $500M, All Garage & Heist Facility',
                'slug' => 'gta-v-online-pc-rank-350-500m',
                'price' => 180000,
                'short_description' => 'Akun Rockstar Games Launcher, Uang Bersih $500.000.000, Bunkers, Oppressor Mk2.',
                'description' => '<p>Akun Sultan GTA V Online PC:</p><ul><li>Rank: 350</li><li>Uang Tunai: $500,000,000 (Legal Heist & Mod Safe)</li><li>Kendaraan: Oppressor Mk2, Toreador, Deluxo, 50+ Supercars modif</li><li>Properti: Kosatka Submarine, Yacht Mewah, Bunker, Agency, Nightclub</li><li>Platform: Rockstar Games Launcher</li></ul>',
                'thumbnail' => null,
                'account_username' => 'gta_sultan_pc',
                'account_password' => 'LosSantos2026$',
                'account_additional_info' => 'Login di Rockstar Games Social Club. Email dan password akun Rockstar akan diserahkan penuh.',
                'status' => 'sold',
            ],
        ];

        foreach ($products as $prodData) {
            Product::firstOrCreate(['slug' => $prodData['slug']], $prodData);
        }

        // 5. Buat 1 Order Lunas Contoh untuk Akun yang Terjual
        $soldProduct = Product::where('slug', 'gta-v-online-pc-rank-350-500m')->first();
        if ($soldProduct) {
            Order::firstOrCreate(
                ['order_number' => 'JB-20260929-GTA01'],
                [
                    'user_id' => $customer->id,
                    'product_id' => $soldProduct->id,
                    'buyer_name' => $customer->name,
                    'buyer_email' => $customer->email,
                    'buyer_phone' => $customer->phone,
                    'total_amount' => $soldProduct->price,
                    'payment_status' => 'paid',
                    'order_status' => 'completed',
                    'payment_type' => 'qris',
                    'paid_at' => now()->subDay(),
                    'notes' => 'Pembelian akun GTA V Online berhasil via QRIS Midtrans.',
                ]
            );
        }
    }
}
