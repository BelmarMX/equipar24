<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            ['title' => 'Migali', 'slug' => 'migali', 'image' => 'migali.png', 'order' => 1, 'created_at' => now()],
            ['title' => ucfirst('concassé'), 'slug' => 'concasse', 'image' => 'concasse.png', 'order' => 2, 'created_at' => now()],
            ['title' => ucfirst('avantco'), 'slug' => 'avantco', 'image' => 'avantco.png', 'order' => 2, 'created_at' => now()],
            ['title' => ucfirst('choice'), 'slug' => 'choice', 'image' => 'choice.png', 'order' => 3, 'created_at' => now()],
            ['title' => ucfirst('galaxy'), 'slug' => 'galaxy', 'image' => 'galaxy.png', 'order' => 4, 'created_at' => now()],
            ['title' => ucfirst('hobart'), 'slug' => 'hobart', 'image' => 'hobart.png', 'order' => 5, 'created_at' => now()],
            ['title' => ucfirst('unox'), 'slug' => 'unox', 'image' => 'unox.png', 'order' => 6, 'created_at' => now()],
            ['title' => ucfirst('migsa'), 'slug' => 'migsa', 'image' => 'migsa.png', 'order' => 7, 'created_at' => now()],
            ['title' => ucfirst('sammic'), 'slug' => 'sammic', 'image' => 'sammic.png', 'order' => 8, 'created_at' => now()],
            ['title' => ucfirst('waring'), 'slug' => 'waring', 'image' => 'waring.png', 'order' => 9, 'created_at' => now()],
            ['title' => ucfirst('atosa'), 'slug' => 'atosa', 'image' => 'atosa.png', 'order' => 10, 'created_at' => now()],
            ['title' => ucfirst('coriat'), 'slug' => 'coriat', 'image' => 'coriat.png', 'order' => 11, 'created_at' => now()],
            ['title' => ucfirst('international'), 'slug' => 'international', 'image' => 'international.png', 'order' => 12, 'created_at' => now()],
            ['title' => ucfirst('friocima'), 'slug' => 'friocima', 'image' => 'friocima.png', 'order' => 13, 'created_at' => now()],
            ['title' => ucfirst('crathco'), 'slug' => 'crathco', 'image' => 'crathco.png', 'order' => 14, 'created_at' => now()],
            ['title' => ucfirst('imperial Range'), 'slug' => 'imperial-range', 'image' => 'imperial-range.png', 'order' => 15, 'created_at' => now()],
            ['title' => ucfirst('rational'), 'slug' => 'rational', 'image' => 'rational.png', 'order' => 16, 'created_at' => now()],
            ['title' => ucfirst('ecomax'), 'slug' => 'ecomax', 'image' => 'ecomax.png', 'order' => 17, 'created_at' => now()],
            ['title' => ucfirst('winterhalter'), 'slug' => 'winterhalter', 'image' => 'winterhalter.png', 'order' => 18, 'created_at' => now()],
            ['title' => ucfirst('edenox'), 'slug' => 'edenox', 'image' => 'edenox.png', 'order' => 19, 'created_at' => now()],
            ['title' => ucfirst('fisher'), 'slug' => 'fisher', 'image' => 'fisher.png', 'order' => 20, 'created_at' => now()],
            ['title' => ucfirst('globe'), 'slug' => 'globe', 'image' => 'globe.png', 'order' => 21, 'created_at' => now()],
            ['title' => ucfirst('hatco'), 'slug' => 'hatco', 'image' => 'hatco.png', 'order' => 22, 'created_at' => now()],
            ['title' => ucfirst('ice-o-matic'), 'slug' => 'ice-o-matic', 'image' => 'ice-o-matic.png', 'order' => 23, 'created_at' => now()],
            ['title' => ucfirst('intertecnica'), 'slug' => 'intertecnica', 'image' => 'intertecnica.png', 'order' => 24, 'created_at' => now()],
            ['title' => ucfirst('metro'), 'slug' => 'metro', 'image' => 'metro.png', 'order' => 25, 'created_at' => now()],
            ['title' => ucfirst('vitamix'), 'slug' => 'vitamix', 'image' => 'vitamix.png', 'order' => 26, 'created_at' => now()],
            ['title' => ucfirst('vulcan'), 'slug' => 'vulcan', 'image' => 'vulcan.png', 'order' => 27, 'created_at' => now()],
            ['title' => ucfirst('casadio'), 'slug' => 'casadio', 'image' => 'casadio.png', 'order' => 28, 'created_at' => now()],
            ['title' => ucfirst('teknikitchen'), 'slug' => 'teknikitchen', 'image' => 'teknikitchen.png', 'order' => 29, 'created_at' => now()],
            ['title' => ucfirst('nemco'), 'slug' => 'nemco', 'image' => 'nemco.png', 'order' => 30, 'created_at' => now()],
        ];
        ProductBrand::insert($records);
    }
}
