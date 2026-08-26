<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['id' => 1, 'category_id' => 1, 'name' => 'kopi Latte Art', 'slug' => 'kopi-latte-art', 'description' => null, 'price' => 20000.00, 'stock' => 15, 'image' => 'products/yhohZvs3zFtf8bluapnl59SVmXeZndUmad7BHTve.jpg', 'is_active' => false, 'is_featured' => false],
            ['id' => 2, 'category_id' => 5, 'name' => 'Ice Tea', 'slug' => 'ice-tea', 'description' => 'Carefully brewed tea, chilled to perfection over ice. Light, clean, and refreshing — the ideal companion for a warm afternoon.', 'price' => 12000.00, 'stock' => 30, 'image' => 'products/SYbOmfae9K82TCtFkHpZwVA9mAPMJrtHdnm0cl58.png', 'is_active' => true, 'is_featured' => false],
            ['id' => 3, 'category_id' => 1, 'name' => 'Ice Americano', 'slug' => 'americano', 'description' => 'Pure espresso balanced with hot water for a clean, bold, and full-bodied cup. The go-to choice for those who love their coffee straightforward and honest.', 'price' => 20000.00, 'stock' => 30, 'image' => 'products/kDPyhVKayN955UdAY7l4Q7LwBlFq63rhn8XsBxwk.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 4, 'category_id' => 1, 'name' => 'Big Americano', 'slug' => 'big-americano', 'description' => 'Everything you love about our Americano, in a larger, bolder serving. More espresso, more depth, and more fuel to power through your day.', 'price' => 20000.00, 'stock' => 30, 'image' => 'products/57CeB1ZMwx989yaMJ04MnnkcpnpvdxfbcYhxU1n5.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 6, 'category_id' => 1, 'name' => 'Cappucino', 'slug' => 'cappucino', 'description' => 'A timeless harmony of espresso, steamed milk, and velvety foam. Creamy, smooth, and aromatic — the classic that never gets old.', 'price' => 25000.00, 'stock' => 29, 'image' => 'products/po4JvzxeNVoeixsLhFG4AOXJh9TAzJleOrBiXpKy.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 7, 'category_id' => 2, 'name' => 'Chocolate Latte', 'slug' => 'chocolate-latte', 'description' => 'Rich chocolate meets fresh espresso and silky steamed milk in one indulgent cup. Sweet, comforting, and the perfect pick-me-up anytime of the day.', 'price' => 30000.00, 'stock' => 30, 'image' => 'products/b75qO0nm6IYktWU920jEd1prYTgzquskz0h2lTMd.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 8, 'category_id' => 1, 'name' => 'Dirty Matcha', 'slug' => 'dirty-matcha', 'description' => "Premium matcha meets a shot of espresso for a bold, layered drink that's earthy, complex, and keeps you sharp all day long.", 'price' => 30000.00, 'stock' => 30, 'image' => 'products/IytgSBXjyL1jQNCmnqd4D6ntC9Lny8Fh5up2wadx.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 9, 'category_id' => 1, 'name' => 'Ice Latte', 'slug' => 'ice-latte', 'description' => 'A shot of fresh espresso poured over cold milk and ice — simple, refreshing, and endlessly satisfying. The classic cold coffee done right.', 'price' => 25000.00, 'stock' => 28, 'image' => 'products/8YJ68HvIYPd3qM4FMnxeBuwpVNnF0xOE9m4BV2kp.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 10, 'category_id' => 1, 'name' => 'Palm Sugar Milk Coffee', 'slug' => 'palm-sugar-milk-coffee', 'description' => "Our house milk coffee sweetened with real palm sugar, bringing a deep caramel warmth that's smooth, natural, and dangerously addictive.", 'price' => 22000.00, 'stock' => 28, 'image' => 'products/sNmSMFry5aIIJ9v1bwzZQLoHFB0XurXbl7obyhrJ.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 11, 'category_id' => 5, 'name' => 'lychee Tea', 'slug' => 'lychee-tea', 'description' => 'Delicate tea infused with the sweet, floral aroma of lychee. Light on the palate and fragrant in every sip — a gentle tropical escape.', 'price' => 25000.00, 'stock' => 26, 'image' => 'products/pmbqXpEk4Szmwee6sd1yMRMw1S2iH8yKenyzeRPi.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 12, 'category_id' => 5, 'name' => 'Lemon Ice Tea', 'slug' => 'ice-lemon-tea', 'description' => 'Chilled tea brightened with a squeeze of fresh lemon for a tangy, sweet, and incredibly refreshing sip. Your instant mood booster in a glass.', 'price' => 20000.00, 'stock' => 28, 'image' => 'products/gKNAS147hjlPoSFbpO2NsupwvNH0m1lTaWOw2sLB.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 13, 'category_id' => 2, 'name' => 'Matcha Latte', 'slug' => 'matcha-latte', 'description' => 'Premium Japanese matcha whisked into creamy steamed milk. Earthy, smooth, and subtly sweet — the perfect balance of calm and focus.', 'price' => 30000.00, 'stock' => 27, 'image' => 'products/rhrWSsKxglvu6itLzpWLMmeswsVHWXKi2SALcpGg.jpg', 'is_active' => true, 'is_featured' => true],
            ['id' => 14, 'category_id' => 1, 'name' => 'Mercy Creamy', 'slug' => 'mercy-creamy', 'description' => "Our signature creation with an irresistibly smooth and creamy texture you won't find anywhere else. One sip is all it takes to make it your new favorite.", 'price' => 25000.00, 'stock' => 29, 'image' => 'products/4WWjrQmnKT12fEvwsTeJJXprj9IUyCdIERDTbpX0.jpg', 'is_active' => true, 'is_featured' => true],
            ['id' => 15, 'category_id' => 5, 'name' => 'Milk Tea', 'slug' => 'milk-tea', 'description' => 'Bold brewed tea blended with fresh milk for a creamy, smooth, and satisfying drink. A comforting classic that works morning, afternoon, or anytime in between.', 'price' => 20000.00, 'stock' => 29, 'image' => 'products/Tb4vCsnKwkHmzk7AuUgbzbDWYKPx8UIkpqpz2S1E.jpg', 'is_active' => true, 'is_featured' => true],
            ['id' => 16, 'category_id' => 2, 'name' => 'Redvelvet Latte', 'slug' => 'redvelvet-latte', 'description' => 'A latte infused with the rich, velvety essence of red velvet — beautiful to look at and just as delicious to drink. Indulgent in every way.', 'price' => 30000.00, 'stock' => 27, 'image' => 'products/QkItMn9MzRCaoxwru7SzT0fcWO0QrnYIRAwfDIxT.jpg', 'is_active' => true, 'is_featured' => false],
            ['id' => 17, 'category_id' => 1, 'name' => 'Strong Aren', 'slug' => 'strong-aren', 'description' => 'Bold coffee meets the rich sweetness of palm sugar in a more intense, punchy profile. For those who want the full experience — no holding back.', 'price' => 25000.00, 'stock' => 29, 'image' => 'products/CxWIcGaUUFTwHvjp7Cm3xBTpTTHLitOON5oDKgXG.jpg', 'is_active' => true, 'is_featured' => false],
        ];

        if (config('filesystems.default') === 'cloudinary') {
            $cloudinaryImages = [
                'kopi-latte-art' => 'products/v4loepswqjgvtmrsyniu',
                'ice-tea' => 'products/qpd5kppkzaopmrexlhfv',
                'americano' => 'products/hnj7tb24xgbuijuaxect',
                'big-americano' => 'products/kp8d59mqhpgkjutomy8z',
                'cappucino' => 'products/cyamivra12mpnegzseit',
                'chocolate-latte' => 'products/qpkarptsfssgzo8l97vg',
                'dirty-matcha' => 'products/m4lsygfpskge927ukett',
                'ice-latte' => 'products/gz8vtg3oj3b38kcihbnj',
                'palm-sugar-milk-coffee' => 'products/pqky5jcyzl0ydipmtibg',
                'lychee-tea' => 'products/bbrmb7iebjsypkbcbvuz',
                'ice-lemon-tea' => 'products/dtut7budri9i836v4cri',
                'matcha-latte' => 'products/fmjrsx89tbngkzycyoia',
                'mercy-creamy' => 'products/geb0rrrr5vidsditmnnp',
                'milk-tea' => 'products/nkmo3fy42senenzl76j2',
                'redvelvet-latte' => 'products/biswfg505rdjawy6gnzv',
                'strong-aren' => 'products/imbxh8ksran3i3ycac4e',
            ];

            foreach ($products as &$data) {
                $data['image'] = $cloudinaryImages[$data['slug']] ?? $data['image'];
            }
            unset($data);
        }

        foreach ($products as $data) {
            Product::firstOrNew(['slug' => $data['slug']])->forceFill($data)->save();
        }
    }
}
