<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        $products = [
            // -------- Produits simples --------
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'ART-001',
                'name' => 'Statue en bois sculpté',
                'slug' => 'statue-bois-sculpte',
                'description' => 'Une magnifique statue artisanale sculptée à la main.',
                'price' => 15000,
                'currency' => 'XOF',
                'stock' => 10,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'ART-002',
                'name' => 'Masque africain',
                'slug' => 'masque-africain',
                'description' => 'Masque traditionnel fait main, idéal pour la décoration.',
                'price' => 12000,
                'currency' => 'XOF',
                'stock' => 6,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'ART-003',
                'name' => 'Peinture murale tribale',
                'slug' => 'peinture-tribale',
                'description' => 'Peinture tribale sur toile en coton.',
                'price' => 20000,
                'currency' => 'XOF',
                'stock' => 3,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'ART-004',
                'name' => 'Bracelet perles colorées',
                'slug' => 'bracelet-perles',
                'description' => 'Bracelet artisanal en perles multicolores.',
                'price' => 3500,
                'currency' => 'XOF',
                'stock' => 25,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'ART-005',
                'name' => 'Panier tressé',
                'slug' => 'panier-tresse',
                'description' => 'Panier artisanal en fibres naturelles.',
                'price' => 5000,
                'currency' => 'XOF',
                'stock' => 12,
                'status' => 1,
                'type' => 'simple'
            ],

            // -------- Produits variables --------
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'TEE-001',
                'name' => 'T-shirt Zaly',
                'slug' => 'tshirt-zaly',
                'description' => 'T-shirt coton bio imprimé Zaly.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'TEE-002',
                'name' => 'T-shirt Heritage',
                'slug' => 'tshirt-heritage',
                'description' => 'T-shirt en coton avec motif patrimoine culturel.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'SND-001',
                'name' => 'Sandales cuir traditionnelles',
                'slug' => 'sandales-cuir',
                'description' => 'Sandales faites main en cuir véritable.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'ROB-001',
                'name' => 'Robe pagne wax',
                'slug' => 'robe-wax',
                'description' => 'Robe en tissu wax coloré.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'CHE-001',
                'name' => 'Chemise en coton',
                'slug' => 'chemise-coton',
                'description' => 'Chemise légère en coton bio.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],

            // -------- Autres produits simples --------
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'DEC-001',
                'name' => 'Décoration murale en macramé',
                'slug' => 'macrame-mural',
                'description' => 'Suspension murale en macramé.',
                'price' => 9000,
                'currency' => 'XOF',
                'stock' => 7,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'LAM-001',
                'name' => 'Lampe en bambou',
                'slug' => 'lampe-bambou',
                'description' => 'Lampe artisanale fabriquée en bambou.',
                'price' => 15000,
                'currency' => 'XOF',
                'stock' => 4,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'TAB-001',
                'name' => 'Table basse sculptée',
                'slug' => 'table-basse-sculptee',
                'description' => 'Table basse en bois sculpté à la main.',
                'price' => 45000,
                'currency' => 'XOF',
                'stock' => 2,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'COU-001',
                'name' => 'Coussin wax',
                'slug' => 'coussin-wax',
                'description' => 'Coussin décoratif en tissu wax coloré.',
                'price' => 6000,
                'currency' => 'XOF',
                'stock' => 15,
                'status' => 1,
                'type' => 'simple'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'SAC-001',
                'name' => 'Sac bandoulière cuir',
                'slug' => 'sac-cuir-bandouliere',
                'description' => 'Sac en cuir avec bandoulière réglable.',
                'price' => 18000,
                'currency' => 'XOF',
                'stock' => 5,
                'status' => 1,
                'type' => 'simple'
            ],

            // -------- Autres produits variables --------
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'CHA-001',
                'name' => 'Chaussures en pagne',
                'slug' => 'chaussures-pagne',
                'description' => 'Chaussures recouvertes de tissu wax.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'JUP-001',
                'name' => 'Jupe pagne',
                'slug' => 'jupe-wax',
                'description' => 'Jupe en tissu wax coloré.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
            [
                'category_id' => Category::where('model', 'Product')->inRandomOrder()->value('id'),
                'sku' => 'POC-001',
                'name' => 'Pochette cuir',
                'slug' => 'pochette-cuir',
                'description' => 'Pochette en cuir pour soirées et événements.',
                'price' => 0,
                'currency' => 'XOF',
                'stock' => 0,
                'status' => 1,
                'type' => 'variable'
            ],
        ];

        foreach ($products as $p) {
            $product = Product::updateOrCreate(['slug' => $p['slug']], $p);

            if ($p['type'] === 'variable') {
                $skus = [
                    ['sku' => $p['sku'] . '-BLK-M', 'attributes' => ['color' => 'Noir', 'size' => 'M'], 'price' => 8000, 'stock' => 5],
                    ['sku' => $p['sku'] . '-BLK-L', 'attributes' => ['color' => 'Noir', 'size' => 'L'], 'price' => 8000, 'stock' => 8],
                    ['sku' => $p['sku'] . '-WHT-M', 'attributes' => ['color' => 'Blanc', 'size' => 'M'], 'price' => 7500, 'stock' => 4],
                ];

                foreach ($skus as $sku) {
                    ProductSku::updateOrCreate(
                        ['sku' => $sku['sku']],
                        [
                            'product_id' => $product->id,
                            'attributes' => $sku['attributes'],
                            'price' => $sku['price'],
                            'currency' => 'XOF',
                            'stock' => $sku['stock'],
                            'status' => 1
                        ]
                    );
                }
            }
        }

    }
}
