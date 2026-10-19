<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CleanCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('1. Memastikan folder storage ada...');
        $productsDir = storage_path('app/public/products');
        $categoriesDir = storage_path('app/public/categories');

        if (!File::isDirectory($productsDir)) {
            File::makeDirectory($productsDir, 0755, true);
        }
        if (!File::isDirectory($categoriesDir)) {
            File::makeDirectory($categoriesDir, 0755, true);
        }

        $this->command->info('2. Membuat icon kategori SVG...');
        $this->generateCategoryIcons($categoriesDir);

        $this->command->info('3. Membuat 30 produk SVG berkualitas tinggi...');
        $productSvgs = $this->generateProductSvgs($productsDir);

        $this->command->info('4. Menghapus produk lama yang tidak ada fotonya...');
        // Cari produk tanpa thumbnail atau thumbnail kosong
        $noPhotoProducts = Product::whereNull('thumbnail')
            ->orWhere('thumbnail', '')
            ->get();

        foreach ($noPhotoProducts as $prod) {
            // Hapus order terkait jika ada
            Order::where('product_id', $prod->id)->delete();
            $prod->delete();
        }

        // Ambil atau buat admin sebagai seller default
        $admin = User::firstOrCreate(
            ['email' => 'admin@jbgame.com'],
            [
                'name' => 'Administrator JB Game',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'phone' => '081234567890',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('5. Membuat kategori game dan 30 produk harga Rp 3.000 - Rp 5.000...');
        $this->seedCategoriesAndProducts($admin, $productSvgs);

        $this->command->info('Berhasil! 30 data produk dengan foto dan kategori siap pakai.');
    }

    private function generateCategoryIcons(string $dir): void
    {
        $icons = [
            'cat_mlbb.svg' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
  <defs>
    <linearGradient id="mlbbCatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#4f46e5" />
      <stop offset="100%" stop-color="#06b6d4" />
    </linearGradient>
  </defs>
  <rect width="100" height="100" rx="28" fill="url(#mlbbCatGrad)" />
  <!-- Shield with Crown -->
  <path d="M50 20 L76 32 C76 56 64 74 50 82 C36 74 24 56 24 32 Z" fill="#ffffff" fill-opacity="0.2" stroke="#ffffff" stroke-width="3" />
  <!-- Crown Icon inside -->
  <path d="M35 55 L38 42 L45 48 L50 38 L55 48 L62 42 L65 55 Z" fill="#fbbf24" stroke="#d97706" stroke-width="1.5" />
  <!-- Stars -->
  <circle cx="50" cy="65" r="4" fill="#fbbf24" />
  <circle cx="40" cy="63" r="3" fill="#ffffff" />
  <circle cx="60" cy="63" r="3" fill="#ffffff" />
</svg>',

            'cat_ff.svg' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
  <defs>
    <linearGradient id="ffCatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#ea580c" />
      <stop offset="100%" stop-color="#dc2626" />
    </linearGradient>
  </defs>
  <rect width="100" height="100" rx="28" fill="url(#ffCatGrad)" />
  <!-- Flame Silhouette -->
  <path d="M50 18 C52 28 62 36 62 48 C62 62 52 72 48 78 C56 76 68 68 68 54 C68 40 58 30 54 22 C52 24 50 28 50 18 Z" fill="#fef08a" />
  <path d="M48 30 C40 38 32 48 32 60 C32 72 42 82 50 82 C38 80 38 66 44 56 C46 52 48 42 48 30 Z" fill="#ffedd5" />
  <path d="M50 48 C54 54 54 62 50 68 C46 62 46 54 50 48 Z" fill="#ea580c" />
</svg>',

            'cat_roblox.svg' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
  <defs>
    <linearGradient id="rbxCatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#059669" />
      <stop offset="100%" stop-color="#0284c7" />
    </linearGradient>
  </defs>
  <rect width="100" height="100" rx="28" fill="url(#rbxCatGrad)" />
  <!-- Iconic Tilted Roblox Cube -->
  <g transform="rotate(-15 50 50)">
    <rect x="28" y="28" width="44" height="44" rx="8" fill="#ffffff" />
    <rect x="42" y="42" width="16" height="16" rx="3" fill="#0284c7" />
  </g>
</svg>',

            'cat_valorant.svg' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
  <defs>
    <linearGradient id="valCatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#e11d48" />
      <stop offset="100%" stop-color="#881337" />
    </linearGradient>
  </defs>
  <rect width="100" height="100" rx="28" fill="url(#valCatGrad)" />
  <!-- Valorant V Slash -->
  <path d="M26 28 L46 64 L54 64 L34 28 Z" fill="#ffffff" />
  <path d="M62 28 L52 46 L60 60 L76 28 Z" fill="#ffffff" fill-opacity="0.85" />
</svg>',

            'cat_fc.svg' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
  <defs>
    <linearGradient id="fcCatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#15803d" />
      <stop offset="100%" stop-color="#047857" />
    </linearGradient>
  </defs>
  <rect width="100" height="100" rx="28" fill="url(#fcCatGrad)" />
  <!-- Soccer Ball & Star -->
  <circle cx="50" cy="50" r="28" fill="#ffffff" stroke="#e2e8f0" stroke-width="3" />
  <!-- Pentagon Center -->
  <polygon points="50,40 59,47 56,58 44,58 41,47" fill="#0f172a" />
  <line x1="50" y1="40" x2="50" y2="22" stroke="#0f172a" stroke-width="2.5" />
  <line x1="59" y1="47" x2="74" y2="42" stroke="#0f172a" stroke-width="2.5" />
  <line x1="56" y1="58" x2="68" y2="70" stroke="#0f172a" stroke-width="2.5" />
  <line x1="44" y1="58" x2="32" y2="70" stroke="#0f172a" stroke-width="2.5" />
  <line x1="41" y1="47" x2="26" y2="42" stroke="#0f172a" stroke-width="2.5" />
</svg>',

            'cat_genshin.svg' => '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
  <defs>
    <linearGradient id="genshinCatGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#7c3aed" />
      <stop offset="100%" stop-color="#4f46e5" />
    </linearGradient>
  </defs>
  <rect width="100" height="100" rx="28" fill="url(#genshinCatGrad)" />
  <!-- Primogem 4-pointed Star -->
  <path d="M50 18 C50 36 64 50 82 50 C64 50 50 64 50 82 C50 64 36 50 18 50 C36 50 50 36 50 18 Z" fill="#fde047" stroke="#ffffff" stroke-width="2" />
  <circle cx="50" cy="50" r="6" fill="#ffffff" />
</svg>',
        ];

        foreach ($icons as $name => $svg) {
            File::put($dir . '/' . $name, trim($svg));
        }
    }

    private function generateProductSvgs(string $dir): array
    {
        $templates = [
            'mlbb' => [
                'bg1' => '#090d16', 'bg2' => '#1e1b4b', 'accent' => '#6366f1', 'badge' => '#fbbf24', 'cat' => 'MOBILE LEGENDS',
                'icon' => '<path d="M400 140 L440 210 L520 220 L460 270 L480 350 L400 310 L320 350 L340 270 L280 220 L360 210 Z" fill="#fbbf24" stroke="#d97706" stroke-width="4" opacity="0.9" />'
            ],
            'ff' => [
                'bg1' => '#180d08', 'bg2' => '#451a03', 'accent' => '#f97316', 'badge' => '#ea580c', 'cat' => 'FREE FIRE',
                'icon' => '<circle cx="400" cy="240" r="80" fill="none" stroke="#ea580c" stroke-width="8" opacity="0.3" /><path d="M400 170 C410 210 440 220 440 250 C440 280 420 300 400 310 C380 300 360 280 360 250 C360 220 390 210 400 170 Z" fill="#f97316" />'
            ],
            'roblox' => [
                'bg1' => '#061a14', 'bg2' => '#064e3b', 'accent' => '#10b981', 'badge' => '#34d399', 'cat' => 'ROBLOX',
                'icon' => '<rect x="340" y="180" width="120" height="120" rx="20" transform="rotate(-15 400 240)" fill="#10b981" /><rect x="380" y="220" width="40" height="40" rx="8" transform="rotate(-15 400 240)" fill="#061a14" />'
            ],
            'val' => [
                'bg1' => '#18080c', 'bg2' => '#4c0519', 'accent' => '#f43f5e', 'badge' => '#e11d48', 'cat' => 'VALORANT',
                'icon' => '<path d="M330 180 L380 270 L400 270 L350 180 Z" fill="#f43f5e" /><path d="M420 180 L395 225 L415 260 L455 180 Z" fill="#ffffff" />'
            ],
            'fc' => [
                'bg1' => '#051f12', 'bg2' => '#14532d', 'accent' => '#22c55e', 'badge' => '#84cc16', 'cat' => 'FC MOBILE',
                'icon' => '<circle cx="400" cy="240" r="70" fill="#ffffff" fill-opacity="0.1" stroke="#22c55e" stroke-width="6" /><polygon points="400,215 425,230 415,258 385,258 375,230" fill="#22c55e" />'
            ],
            'genshin' => [
                'bg1' => '#120b24', 'bg2' => '#2e1065', 'accent' => '#a855f7', 'badge' => '#c084fc', 'cat' => 'GENSHIN IMPACT',
                'icon' => '<path d="M400 160 C400 205 435 240 480 240 C435 240 400 275 400 320 C400 275 365 240 320 240 C365 240 400 205 400 160 Z" fill="#c084fc" /><circle cx="400" cy="240" r="14" fill="#ffffff" />'
            ],
        ];

        $svgPaths = [];

        for ($i = 1; $i <= 30; $i++) {
            $catKey = match (intval(ceil($i / 5))) {
                1 => 'mlbb',
                2 => 'ff',
                3 => 'roblox',
                4 => 'val',
                5 => 'fc',
                default => 'genshin',
            };

            $t = $templates[$catKey];
            $fileName = sprintf('product_card_%02d.svg', $i);
            $fullPath = $dir . '/' . $fileName;

            $badgeNum = (($i - 1) % 5) + 1;
            $tierName = match ($badgeNum) {
                1 => 'STARTER SPECIAL',
                2 => 'VERIFIED PRO',
                3 => 'ELITE VAULT',
                4 => 'MASTER CLASS',
                5 => 'LEGENDARY SULTAN',
            };

            $priceFormatted = 'Rp ' . number_format(2500 + ($badgeNum * 500), 0, ',', '.');

            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500" width="800" height="500">
  <defs>
    <linearGradient id="bgGrad{$i}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$t['bg1']}" />
      <stop offset="60%" stop-color="{$t['bg2']}" />
      <stop offset="100%" stop-color="#020617" />
    </linearGradient>
    <linearGradient id="accentGrad{$i}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$t['accent']}" />
      <stop offset="100%" stop-color="{$t['badge']}" />
    </linearGradient>
  </defs>

  <!-- Dark Background -->
  <rect width="800" height="500" fill="url(#bgGrad{$i})" />

  <!-- Ambient Glow -->
  <circle cx="400" cy="240" r="160" fill="{$t['accent']}" opacity="0.12" filter="blur(60px)" />
  <circle cx="700" cy="80" r="120" fill="{$t['badge']}" opacity="0.1" filter="blur(50px)" />

  <!-- Tech Grid Background -->
  <g opacity="0.08" stroke="#ffffff" stroke-width="1.5" fill="none">
    <line x1="0" y1="100" x2="800" y2="100" />
    <line x1="0" y1="200" x2="800" y2="200" />
    <line x1="0" y1="300" x2="800" y2="300" />
    <line x1="0" y1="400" x2="800" y2="400" />
    <line x1="200" y1="0" x2="200" y2="500" />
    <line x1="400" y1="0" x2="400" y2="500" />
    <line x1="600" y1="0" x2="600" y2="500" />
  </g>

  <!-- Big Central Icon Art -->
  {$t['icon']}

  <!-- Top Badges -->
  <g transform="translate(40, 40)">
    <!-- Category Pill -->
    <rect width="180" height="38" rx="19" fill="#ffffff" fill-opacity="0.1" stroke="#ffffff" stroke-opacity="0.2" stroke-width="1.5" />
    <text x="90" y="24" fill="#ffffff" font-family="'Plus Jakarta Sans', sans-serif, system-ui" font-size="12" font-weight="900" text-anchor="middle" letter-spacing="2">{$t['cat']}</text>
  </g>

  <g transform="translate(235, 40)">
    <!-- Instant Delivery Pill -->
    <rect width="150" height="38" rx="19" fill="#10b981" fill-opacity="0.2" stroke="#10b981" stroke-width="1.5" />
    <text x="75" y="24" fill="#34d399" font-family="'Plus Jakarta Sans', sans-serif, system-ui" font-size="11" font-weight="800" text-anchor="middle" letter-spacing="1">⚡ AUTO QRIS</text>
  </g>

  <!-- Price Badge (Top Right) -->
  <g transform="translate(620, 40)">
    <rect width="140" height="38" rx="19" fill="url(#accentGrad{$i})" />
    <text x="70" y="24" fill="#ffffff" font-family="'Plus Jakarta Sans', sans-serif, system-ui" font-size="13" font-weight="900" text-anchor="middle">{$priceFormatted}</text>
  </g>

  <!-- Bottom Info Container -->
  <rect x="40" y="380" width="720" height="85" rx="20" fill="#ffffff" fill-opacity="0.08" stroke="#ffffff" stroke-opacity="0.12" stroke-width="1.5" />

  <text x="70" y="418" fill="#ffffff" font-family="'Plus Jakarta Sans', sans-serif, system-ui" font-size="20" font-weight="900" letter-spacing="0.5">EDISI AKUN #{$i} • {$tierName}</text>
  <text x="70" y="445" fill="#94a3b8" font-family="'Plus Jakarta Sans', sans-serif, system-ui" font-size="13" font-weight="600">Garansi Anti Hackback 100% • Monsep Clean Bind • Instant Delivery</text>

  <!-- Verified Watermark Icon -->
  <g transform="translate(710, 405)">
    <circle cx="15" cy="15" r="16" fill="#10b981" />
    <path d="M9 15 L13 19 L21 11" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
  </g>
</svg>
SVG;

            File::put($fullPath, trim($svg));
            $svgPaths[$i] = 'products/' . $fileName;
        }

        return $svgPaths;
    }

    private function seedCategoriesAndProducts(User $admin, array $svgPaths): void
    {
        $categoriesData = [
            'mobile-legends' => [
                'name' => 'Mobile Legends',
                'slug' => 'mobile-legends',
                'icon' => 'categories/cat_mlbb.svg',
                'description' => 'Akun MLBB Mythic, Glory, Immortal, Full Skin Collector & Legend Siap Pakai.',
            ],
            'free-fire' => [
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'icon' => 'categories/cat_ff.svg',
                'description' => 'Akun FF Old, Bundle Cobra, AK Draco Blue Flame, SG Rapper, Master Bintang.',
            ],
            'roblox' => [
                'name' => 'Roblox',
                'slug' => 'roblox',
                'icon' => 'categories/cat_roblox.svg',
                'description' => 'Akun Blox Fruits Max Level, Godhuman, Mythical Fruit, Robux Avatar Sultan.',
            ],
            'valorant' => [
                'name' => 'Valorant',
                'slug' => 'valorant',
                'icon' => 'categories/cat_valorant.svg',
                'description' => 'Akun Valorant Rank Radiant/Immortal/Gold, Vandal Kuronami, Prime, Reaver.',
            ],
            'fc-mobile' => [
                'name' => 'FC Mobile',
                'slug' => 'fc-mobile',
                'icon' => 'categories/cat_fc.svg',
                'description' => 'Akun EA Sports FC Mobile OVR 90+, Full Icon, Ronaldo & Messi Siap Push.',
            ],
            'genshin-impact' => [
                'name' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'icon' => 'categories/cat_genshin.svg',
                'description' => 'Akun Genshin Impact AR 20 - 55, Raiden Shogun, Furina, Hu Tao, Clean Bind.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $slug => $cData) {
            $categories[$slug] = Category::updateOrCreate(['slug' => $slug], $cData);
        }

        // 30 Data Produk
        $productsCatalog = [
            // 1-5: Mobile Legends (Rp 3.000 - Rp 5.000)
            [
                'cat' => 'mobile-legends',
                'title' => 'MLBB Smurf Epic Full Hero Mage & Assassin',
                'slug' => 'mlbb-smurf-epic-hero-mage-assassin',
                'price' => 3000,
                'short' => 'Rank Epic V, Winrate 72%, Hero 45, Skin 38, Clean Bind Moonton.',
                'desc' => '<p>Detail Akun MLBB Smurf Epic:</p><ul><li>Rank: Epic V (Siap Push Legend/Mythic)</li><li>Hero: 45 Hero</li><li>Skin: 38 Skin (Termasuk Skin Elite & Special)</li><li>Emblem: Mage & Assassin Lv. 50</li><li>Bind: Moonton Sepaket (Email Bawaan Diserahkan)</li><li>Garansi: Anti-Hackback 100% Seumur Hidup</li></ul>',
                'user' => 'mlbb_smurf_01', 'pass' => 'MlbbEpic3000!', 'method' => 'Moonton',
            ],
            [
                'cat' => 'mobile-legends',
                'title' => 'MLBB Grandmaster Akun Polos Siap Push WR 80%',
                'slug' => 'mlbb-grandmaster-polos-wr-80',
                'price' => 3500,
                'short' => 'Rank Grandmaster I, Winrate 80%, Emblem Assassin Max, Monsep Aman.',
                'desc' => '<p>Spesifikasi Akun:</p><ul><li>Rank: GM I Bintang 4</li><li>Hero: 52 Hero</li><li>Skin: 42 Skin</li><li>WR Tinggi 80% (Sangat cocok untuk jasa joki/smurf)</li><li>Akun Pribadi Tangan Pertama</li></ul>',
                'user' => 'mlbb_gm_02', 'pass' => 'MlbbGm3500@', 'method' => 'Moonton',
            ],
            [
                'cat' => 'mobile-legends',
                'title' => 'MLBB Legend V Starter All Role Emblem Max',
                'slug' => 'mlbb-legend-starter-all-role',
                'price' => 4000,
                'short' => 'Rank Legend V, All Role Hero 65, Skin 55, Emblem Rata 55+, Garansi.',
                'desc' => '<p>Spesifikasi Akun Legend:</p><ul><li>Rank: Legend V</li><li>Hero: 65 Hero Lengkap All Role</li><li>Skin: 55 Skin (Collector Ling & Epic Roger)</li><li>Bind: Moonton Bersih Tidak Ada Minus</li></ul>',
                'user' => 'mlbb_legend_03', 'pass' => 'MlbbLegend4000#', 'method' => 'Moonton',
            ],
            [
                'cat' => 'mobile-legends',
                'title' => 'MLBB Epic Skin Special Chou & Gusion KOF Siap Gas',
                'slug' => 'mlbb-epic-special-chou-gusion',
                'price' => 4500,
                'short' => 'Skin Special Chou Iori/KOF, Gusion K’, Hero 70, Monsep Sepaket Aman.',
                'desc' => '<p>Kelebihan Akun:</p><ul><li>Koleksi Skin Favorit: Gusion KOF, Chou Elite & Special</li><li>Hero: 70 Hero</li><li>Total Skin: 68 Skin</li><li>Status: Monsep Email Gmail Bawaan Diberikan</li></ul>',
                'user' => 'mlbb_kof_04', 'pass' => 'MlbbKof4500$', 'method' => 'Moonton',
            ],
            [
                'cat' => 'mobile-legends',
                'title' => 'MLBB Mythic Calon Immortal Akun Siap Turnamen',
                'slug' => 'mlbb-mythic-calon-immortal-turney',
                'price' => 5000,
                'short' => 'Rank Mythic 25 Stars, Hero 85, Skin 90, Full Emblem Max 60, Garansi 100%.',
                'desc' => '<p>Akun MLBB High Rank:</p><ul><li>Rank: Mythic 25 Stars</li><li>Hero: 85 Hero Siap Turnamen</li><li>Skin: 90 Skin (2 Collector + Epic Limit)</li><li>Emblem: All Max Level 60</li><li>Garansi: Garansi Resmi ANDRA STORE Anti Hackback</li></ul>',
                'user' => 'mlbb_mythic_05', 'pass' => 'MlbbMythic5000%', 'method' => 'Moonton',
            ],

            // 6-10: Free Fire (Rp 3.000 - Rp 5.000)
            [
                'cat' => 'free-fire',
                'title' => 'Free Fire Akun Polos Siap Rank Level 25 Vault Bagus',
                'slug' => 'free-fire-polos-siap-rank-lv-25',
                'price' => 3000,
                'short' => 'Level 25, Vault lumayan banyak bundle lawas, siap ranked, login Google.',
                'desc' => '<p>Detail Akun FF:</p><ul><li>Level: 25 Siap Ranked</li><li>Karakter: Alok, Chrono, Kelly Max</li><li>Login: Akun Google Bersih</li><li>Garansi: 100% Anti Hackback</li></ul>',
                'user' => 'ff_polos_06@gmail.com', 'pass' => 'FfPolos3000!', 'method' => 'Google',
            ],
            [
                'cat' => 'free-fire',
                'title' => 'Free Fire Bundle Old Set Hip Hop Starter Keren',
                'slug' => 'free-fire-bundle-old-hip-hop',
                'price' => 3500,
                'short' => 'Bundle Old Hip Hop Starter, Senjata MP40 Incubator, Login FB Polos.',
                'desc' => '<p>Spesifikasi Akun:</p><ul><li>Bundle: Set Hip Hop Old</li><li>Senjata: MP40 Poker, Scar Cupid</li><li>Login: Facebook Bebas A2F</li><li>Status Bind: Bersih</li></ul>',
                'user' => 'ff_hiphop_07@fb.com', 'pass' => 'FfHiphop3500@', 'method' => 'Facebook',
            ],
            [
                'cat' => 'free-fire',
                'title' => 'Free Fire Akun Diamond Vault 1.500 DM Siap Spin',
                'slug' => 'free-fire-diamond-vault-1500-dm',
                'price' => 4000,
                'short' => 'Sisa 1.500 Diamond di dalam akun, siap spin event terbaru, akun resmi.',
                'desc' => '<p>Keuntungan Akun:</p><ul><li>Saldo Diamond: 1.500 DM Murni Topup Legal</li><li>Bisa langsung dipakai gacha event</li><li>Login: Google Sepaket</li></ul>',
                'user' => 'ff_vault_08@gmail.com', 'pass' => 'FfVault4000#', 'method' => 'Google',
            ],
            [
                'cat' => 'free-fire',
                'title' => 'Free Fire AK Draco Blue Flame Lv.4 + Bundle Cobra',
                'slug' => 'free-fire-ak-draco-lv4-cobra',
                'price' => 4500,
                'short' => 'AK Draco Lv.4 Efek Tembak Menyala + Set Cobra Merah, Akun Old Mantap.',
                'desc' => '<p>Spesifikasi Sultan FF:</p><ul><li>Evo Gun: AK Draco Blue Flame Lv.4</li><li>Bundle: Cobra Rage Merah</li><li>Emote: Emote Draco & Cobra Lengkap</li><li>Login: Google Bersih</li></ul>',
                'user' => 'ff_draco_09@gmail.com', 'pass' => 'FfDraco4500$', 'method' => 'Google',
            ],
            [
                'cat' => 'free-fire',
                'title' => 'Free Fire Master Bintang 10 Clean Bind Garansi',
                'slug' => 'free-fire-master-bintang-10-clean',
                'price' => 5000,
                'short' => 'Rank Master Bintang 10, SG2 Rapper Ungu, Emote Duduk Kursi Sultan.',
                'desc' => '<p>Spesifikasi Akun Master:</p><ul><li>Rank: Master Bintang 10 (High Tier)</li><li>Senjata: SG2 Rapper Ungu, M1887 One Punch Man</li><li>Koleksi: Emote Kursi Sultan & Taunt</li><li>Garansi: Resmi Seumur Hidup</li></ul>',
                'user' => 'ff_master_10@gmail.com', 'pass' => 'FfMaster5000%', 'method' => 'Google',
            ],

            // 11-15: Roblox (Rp 3.000 - Rp 5.000)
            [
                'cat' => 'roblox',
                'title' => 'Roblox Starter Clean Email No PIN Siap Main',
                'slug' => 'roblox-starter-clean-email-no-pin',
                'price' => 3000,
                'short' => 'Akun Roblox polos tanpa email & tanpa PIN, langsung bind data Anda.',
                'desc' => '<p>Spesifikasi Akun Roblox:</p><ul><li>Status Email: Belum Terikat (Bebas isi email Anda)</li><li>PIN Akun: Kosong (Aman 100%)</li><li>Bisa dipakai untuk game apapun di Roblox</li></ul>',
                'user' => 'rbx_clean_11', 'pass' => 'RbxClean3000!', 'method' => 'Roblox',
            ],
            [
                'cat' => 'roblox',
                'title' => 'Roblox Blox Fruits Second Sea Godhuman Ready',
                'slug' => 'roblox-blox-fruits-second-sea-godhuman',
                'price' => 3500,
                'short' => 'Blox Fruits Level 1500+ (Second Sea), Bahan Godhuman lengkap, aman.',
                'desc' => '<p>Detail Akun Blox Fruits:</p><ul><li>Sea: Second Sea (Level 1500+)</li><li>Melee: Electric Claw & Superhuman Siap Godhuman</li><li>Beli: 5.000.000 Beli + 10.000 Fragment</li></ul>',
                'user' => 'rbx_sea2_12', 'pass' => 'RbxSea3500@', 'method' => 'Roblox',
            ],
            [
                'cat' => 'roblox',
                'title' => 'Roblox Blox Fruits Max Level + Fruit Dough Awaken',
                'slug' => 'roblox-blox-fruits-max-level-dough',
                'price' => 4000,
                'short' => 'Level 2550 (Max), Fruit Dough Full Awaken, Melee Sanguine Art.',
                'desc' => '<p>Spesifikasi Blox Fruits Max:</p><ul><li>Level: 2550 (Max Level Terbaru)</li><li>Fruit: Dough Full Awaken V2</li><li>Melee: Sanguine Art & Godhuman</li><li>Pedang: Cursed Dual Katana (CDK)</li></ul>',
                'user' => 'rbx_dough_13', 'pass' => 'RbxDough4000#', 'method' => 'Roblox',
            ],
            [
                'cat' => 'roblox',
                'title' => 'Roblox Avatar Sultan 1.000 Robux Inventory Keren',
                'slug' => 'roblox-avatar-sultan-1000-robux',
                'price' => 4500,
                'short' => 'Item avatar senilai 1.000 Robux, rambut, animasi Korblox bundle keren.',
                'desc' => '<p>Detail Avatar Roblox:</p><ul><li>Inventory: Item bernilai ribuan Robux</li><li>Animasi: Ninja Animation Package</li><li>Baju & Celana: Trendy Designer Roblox</li><li>Email: Clean Unverified</li></ul>',
                'user' => 'rbx_avatar_14', 'pass' => 'RbxAvatar4500$', 'method' => 'Roblox',
            ],
            [
                'cat' => 'roblox',
                'title' => 'Roblox Blox Fruits Third Sea Mythical Leopard + CDK',
                'slug' => 'roblox-blox-fruits-third-sea-leopard',
                'price' => 5000,
                'short' => 'Third Sea Max Level, Buah Mythical Leopard Aktif, Cursed Dual Katana.',
                'desc' => '<p>Akun Blox Fruits Dewa:</p><ul><li>Sea: Third Sea Level 2550 Max</li><li>Buah: Mythical Leopard Terpasang Mastery 600</li><li>Weapon: CDK + Soul Guitar</li><li>Bounty: 5.000.000+ Pirate Bounty</li></ul>',
                'user' => 'rbx_leopard_15', 'pass' => 'RbxLeopard5000%', 'method' => 'Roblox',
            ],

            // 16-20: Valorant (Rp 3.000 - Rp 5.000)
            [
                'cat' => 'valorant',
                'title' => 'Valorant Starter Level 20 Siap Ranked Competitive',
                'slug' => 'valorant-starter-lv20-ready-ranked',
                'price' => 3000,
                'short' => 'Level 20 Riot Games, Siap langsung push rank tanpa harus grinding level.',
                'desc' => '<p>Detail Akun Valorant:</p><ul><li>Level Akun: Level 20 Pas</li><li>Status Ranked: Siap Matchmaking Competitive</li><li>Region: AP / Asia (Jakarta / Singapore Ping Rendah)</li><li>First Email: Bersih Siap Bind</li></ul>',
                'user' => 'val_starter_16', 'pass' => 'ValStarter3000!', 'method' => 'Riot Games',
            ],
            [
                'cat' => 'valorant',
                'title' => 'Valorant Iron/Bronze Rank Akun Smurf Bersih MMR Bagus',
                'slug' => 'valorant-iron-bronze-smurf-bersih',
                'price' => 3500,
                'short' => 'Rank Bronze 2, MMR stabil, tidak ada penalty/voice ban, akun pribadi.',
                'desc' => '<p>Spesifikasi Smurf Valorant:</p><ul><li>Rank: Bronze 2</li><li>Agen Unlocked: Reyna, Jett, Omen, Killjoy</li><li>Riwayat: Bebas AFK & Toxic Ban</li><li>Keamanan: Garansi ANDRA STORE</li></ul>',
                'user' => 'val_bronze_17', 'pass' => 'ValBronze3500@', 'method' => 'Riot Games',
            ],
            [
                'cat' => 'valorant',
                'title' => 'Valorant Silver 3 Vandal Prime Unlocked Efek Laser',
                'slug' => 'valorant-silver-vandal-prime',
                'price' => 4000,
                'short' => 'Rank Silver 3, Skin Vandal Prime Max Level Efek Reload & Finisher Keren.',
                'desc' => '<p>Spesifikasi Akun:</p><ul><li>Skin Unggulan: Prime Vandal (Full Variant & Finisher)</li><li>Rank: Silver 3 (Hampir Gold)</li><li>Radianite: Tersisa 40 Radianite Points</li><li>Login: Riot Client Langsung</li></ul>',
                'user' => 'val_prime_18', 'pass' => 'ValPrime4000#', 'method' => 'Riot Games',
            ],
            [
                'cat' => 'valorant',
                'title' => 'Valorant Gold 2 Phantom Oni + Battlepass Season Ini',
                'slug' => 'valorant-gold-phantom-oni-bp',
                'price' => 4500,
                'short' => 'Rank Gold 2, Phantom Oni Suara Top Tier, Battlepass Aktif Level 40.',
                'desc' => '<p>Kelebihan Akun Gold:</p><ul><li>Skin: Oni Phantom (Top Tier Phantom)</li><li>Battlepass: On Progress Level 40</li><li>Rank: Gold 2 Posisi Aman</li><li>Email: Clean First Hand</li></ul>',
                'user' => 'val_oni_19', 'pass' => 'ValOni4500$', 'method' => 'Riot Games',
            ],
            [
                'cat' => 'valorant',
                'title' => 'Valorant Platinum Kuronami Vandal Clean Riot Garansi',
                'slug' => 'valorant-platinum-kuronami-vandal',
                'price' => 5000,
                'short' => 'Rank Platinum 1, Skin Kuronami Vandal Animasi Petir, Clean Email.',
                'desc' => '<p>Spesifikasi Akun Sultan Valorant:</p><ul><li>Skin Sultan: Kuronami Vandal (Skin Paling Dicari)</li><li>Rank: Platinum 1 High Skill</li><li>Agen: Full Unlocked Semua Agen</li><li>Garansi: Anti Hackback Seumur Hidup</li></ul>',
                'user' => 'val_kuro_20', 'pass' => 'ValKuro5000%', 'method' => 'Riot Games',
            ],

            // 21-25: FC Mobile (Rp 3.000 - Rp 5.000)
            [
                'cat' => 'fc-mobile',
                'title' => 'FC Mobile Starter OVR 88 Koin 5 Juta Siap Gacha',
                'slug' => 'fc-mobile-starter-ovr-88-koin-5m',
                'price' => 3000,
                'short' => 'Skuad OVR 88, Koin 5.000.000 siap beli pemain pasar transfer.',
                'desc' => '<p>Detail Akun FC Mobile:</p><ul><li>OVR Tim: 88</li><li>Koin Pasar: 5.000.000 Coins</li><li>Bind: Akun EA (Mudah diubah)</li></ul>',
                'user' => 'fc_starter_21@ea.com', 'pass' => 'FcStarter3000!', 'method' => 'EA Account',
            ],
            [
                'cat' => 'fc-mobile',
                'title' => 'FC Mobile Squad OVR 92 Full Premier League Mantap',
                'slug' => 'fc-mobile-squad-ovr-92-epl',
                'price' => 3500,
                'short' => 'OVR 92 skuad Liga Inggris (Salah, De Bruyne, Van Dijk), chemistry max.',
                'desc' => '<p>Detail Skuad:</p><ul><li>OVR: 92</li><li>Pemain Kunci: Mo Salah, Kevin De Bruyne, VVD</li><li>Koin: 8.000.000 Coins</li><li>Garansi: 100% Aman</li></ul>',
                'user' => 'fc_epl_22@ea.com', 'pass' => 'FcEpl3500@', 'method' => 'EA Account',
            ],
            [
                'cat' => 'fc-mobile',
                'title' => 'FC Mobile OVR 95 Icon Zidane & Haaland Top Skor',
                'slug' => 'fc-mobile-ovr-95-zidane-haaland',
                'price' => 4000,
                'short' => 'OVR 95 ada Icon Zinedine Zidane & Erling Haaland Level Rank Up 4.',
                'desc' => '<p>Spesifikasi Tim:</p><ul><li>OVR: 95</li><li>Icon Legenda: Zinedine Zidane OVR 94 CAM</li><li>Striker: Erling Haaland Red Rank</li><li>Koin: 12.000.000 Coins</li></ul>',
                'user' => 'fc_zidane_23@ea.com', 'pass' => 'FcZidane4000#', 'method' => 'EA Account',
            ],
            [
                'cat' => 'fc-mobile',
                'title' => 'FC Mobile OVR 98 Squad Sultan 20M Koin Transfer',
                'slug' => 'fc-mobile-ovr-98-squad-sultan',
                'price' => 4500,
                'short' => 'OVR 98 Full TOTY & Icon, saldo koin 20 juta melimpah, siap H2H Champion.',
                'desc' => '<p>Kelebihan Skuad Sultan:</p><ul><li>OVR: 98 (Sangat tinggi)</li><li>Saldo Koin: 20.000.000 Coins Bebas Belanja</li><li>Rank H2H: Legendary I Siap FIFA Champion</li></ul>',
                'user' => 'fc_sultan_24@ea.com', 'pass' => 'FcSultan4500$', 'method' => 'EA Account',
            ],
            [
                'cat' => 'fc-mobile',
                'title' => 'FC Mobile OVR 100 Mbappe + Messi TOTY Squad Impian',
                'slug' => 'fc-mobile-ovr-100-mbappe-messi',
                'price' => 5000,
                'short' => 'OVR tembus 100, duet mematikan Mbappe 99 & Messi 99 TOTY, akun langka.',
                'desc' => '<p>Detail Akun OVR 100:</p><ul><li>OVR: 100 (Max Rating)</li><li>Pemain: Kylian Mbappe TOTY + Lionel Messi TOTY</li><li>Icon: R9 Ronaldo Nazario & Maldini</li><li>Garansi: Resmi ANDRA STORE Anti Hackback</li></ul>',
                'user' => 'fc_100_25@ea.com', 'pass' => 'Fc1005000%', 'method' => 'EA Account',
            ],

            // 26-30: Genshin Impact (Rp 3.000 - Rp 5.000)
            [
                'cat' => 'genshin-impact',
                'title' => 'Genshin Impact AR 20 Starter Furina Hydro Archon',
                'slug' => 'genshin-ar20-starter-furina',
                'price' => 3000,
                'short' => 'AR 20, Karakter Bintang 5 Furina Hydro Archon, Primogem tersisa banyak.',
                'desc' => '<p>Detail Akun Genshin Starter:</p><ul><li>Adventure Rank: AR 20</li><li>B5 Character: Furina (Hydro Archon)</li><li>Server: Asia</li><li>Status Bind: Username only / Clean Email</li></ul>',
                'user' => 'gi_furina_26', 'pass' => 'GiFurina3000!', 'method' => 'Hoyoverse',
            ],
            [
                'cat' => 'genshin-impact',
                'title' => 'Genshin Impact AR 25 Raiden Shogun Siap Build',
                'slug' => 'genshin-ar25-raiden-shogun',
                'price' => 3500,
                'short' => 'AR 25, Bintang 5 Raiden Shogun (Electro Archon) + Bennet C1, Inazuma Open.',
                'desc' => '<p>Spesifikasi Akun:</p><ul><li>AR: 25</li><li>B5: Raiden Shogun</li><li>Support B4: Bennett C1, Xingqiu, Xiangling (National Team Siap)</li><li>Server: Asia</li></ul>',
                'user' => 'gi_raiden_27', 'pass' => 'GiRaiden3500@', 'method' => 'Hoyoverse',
            ],
            [
                'cat' => 'genshin-impact',
                'title' => 'Genshin Impact AR 35 Hu Tao + Senjata Staff of Homa',
                'slug' => 'genshin-ar35-hu-tao-staff-of-homa',
                'price' => 4000,
                'short' => 'AR 35, Duet maut Hu Tao B5 + Senjata Signature Staff of Homa, Damage Sakit.',
                'desc' => '<p>Detail Akun:</p><ul><li>AR: 35</li><li>B5 Karakter: Hu Tao</li><li>B5 Senjata: Staff of Homa (Signature Weapon)</li><li>Server: Asia Ping Bagus</li></ul>',
                'user' => 'gi_hutao_28', 'pass' => 'GiHutao4000#', 'method' => 'Hoyoverse',
            ],
            [
                'cat' => 'genshin-impact',
                'title' => 'Genshin Impact AR 45 Nahida + Kazuha Full Primogem',
                'slug' => 'genshin-ar45-nahida-kazuha',
                'price' => 4500,
                'short' => 'AR 45, Nahida Dendro Archon + Kaedehara Kazuha, Map Sumeru 80%, 40 Wish.',
                'desc' => '<p>Kelebihan Akun:</p><ul><li>AR: 45</li><li>B5: Nahida + Kaedehara Kazuha (Duo Support Tier SSS)</li><li>Tabungan: 6.000 Primogem + 10 Intertwined Fate</li><li>Status: Monsep Bersih</li></ul>',
                'user' => 'gi_nahida_29', 'pass' => 'GiNahida4500$', 'method' => 'Hoyoverse',
            ],
            [
                'cat' => 'genshin-impact',
                'title' => 'Genshin Impact AR 50 Neuvillette C1 Signature Siap Spiral Abyss',
                'slug' => 'genshin-ar50-neuvillette-c1-signature',
                'price' => 5000,
                'short' => 'AR 50, Neuvillette C1 + Tome of the Eternal Flow, Solo Spiral Abyss Lantai 12.',
                'desc' => '<p>Akun Genshin End-Game Dewa:</p><ul><li>AR: 50 (World Level 7)</li><li>B5: Neuvillette Constellation 1 (Anti Stagger)</li><li>Senjata: Tome of the Eternal Flow R1</li><li>Spiral Abyss: Mudah tembus Floor 12 Bintang 36</li><li>Garansi: Resmi ANDRA STORE Anti Hackback Seumur Hidup</li></ul>',
                'user' => 'gi_neuv_30', 'pass' => 'GiNeuv5000%', 'method' => 'Hoyoverse',
            ],
        ];

        foreach ($productsCatalog as $idx => $item) {
            $prodNum = $idx + 1;
            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $categories[$item['cat']]->id,
                    'seller_id' => $admin->id,
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'price' => $item['price'],
                    'short_description' => $item['short'],
                    'description' => $item['desc'],
                    'thumbnail' => $svgPaths[$prodNum] ?? 'products/product_card_01.svg',
                    'images' => [
                        $svgPaths[$prodNum] ?? 'products/product_card_01.svg',
                    ],
                    'account_username' => $item['user'],
                    'account_password' => $item['pass'],
                    'account_additional_info' => 'Login via ' . $item['method'] . '. Username: ' . $item['user'] . '. Garansi anti hackback seumur hidup. Data akun telah diverifikasi admin.',
                    'status' => 'available',
                ]
            );
        }
    }
}
