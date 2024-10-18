<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
                ['state_id' => 14, 'city_id' => 572, 'title' => 'Gdl Matriz', 'street' => 'Av. Cvln. Jorge Álvarez del Castillo', 'number' => '1442', 'neighborhood' => 'Lomas del Country', 'building' => NULL, 'country' => 'México', 'phone' => '3328862661', 'link' => 'https://maps.app.goo.gl/SkDp2znznD5FjBPv6', 'embed_code' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7464.423907058208!2d-103.36637900000001!3d20.701616!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8573938c634944dd!2sEqui-par%20Cocinas%20Industriales!5e0!3m2!1ses!2smx!4v1645771932888!5m2!1ses!2smx', 'created_at' => now()]
            ,   ['state_id' => 14, 'city_id' => 572, 'title' => 'Gdl Showroom', 'street' => 'Av. 16 de septiembre', 'number' => '665', 'neighborhood' => 'Mexicaltzingo', 'building' => NULL, 'country' => 'México', 'phone' => '3328862661', 'link' => 'https://maps.app.goo.gl/Wm8peAwcUb3paqtz9', 'embed_code' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4676.33574189778!2d-103.35068286458595!3d20.665050103700274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b300a6ca8bdb%3A0xc9c8ebd1f7c027ca!2sEquipar%20cocinas%20Industriales!5e0!3m2!1ses-419!2smx!4v1651552749341!5m2!1ses-419!2smx', 'created_at' => now()]
            ,   ['state_id' => 14, 'city_id' => 572, 'title' => 'Guadalajara', 'street' => 'Av. Plan de San Luis', 'number' => '1850', 'neighborhood' => 'Lomas del Country', 'building' => NULL, 'country' => 'México', 'phone' => '3322876603', 'link' => 'https://maps.app.goo.gl/ePQWhR2uwJWKjVhbA', 'embed_code' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4084.2490156145327!2d-103.36827142154223!3d20.69742080525417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428af5cee6f4d17%3A0xde3443a6033c0b2a!2sEquipar%20cocinas%20industriales!5e0!3m2!1ses!2smx!4v1728539873512!5m2!1ses!2smx', 'created_at' => now()]
            ,   ['state_id' => 14, 'city_id' => 653, 'title' => 'Zapopan', 'street' => 'Av. Mariano Otero', 'number' => '3519', 'neighborhood' => 'La Calma', 'building' => NULL, 'country' => 'México', 'phone' => '3335751334', 'link' => 'https://maps.app.goo.gl/B5UKEZ69yei9teLN8', 'embed_code' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d16562.04313701228!2d-103.42620814629664!3d20.637281778034207!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3c7c1293fe6c83fd!2sEqui-par!5e0!3m2!1ses!2smx!4v1645772008948!5m2!1ses!2smx', 'created_at' => now()]
            ,   ['state_id' => 18, 'city_id' => 949, 'title' => 'Puerto Vallarta', 'street' => 'Blvd. Riviera Nayarit', 'number' => '2, Local 7 y 8', 'neighborhood' => 'Nuevo Vallarta', 'building' => 'Plaza El Roble', 'country' => 'México', 'phone' => '3291116725', 'link' => 'https://maps.app.goo.gl/MfFQ4r7kaUumuUGy8', 'embed_code' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1660.5055586225783!2d-105.27505461345973!3d20.709479137104474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842147c84338c56f%3A0x34b397c7230e556d!2sEquipar%20Cocinas%20industriales%20vallarta!5e0!3m2!1ses-419!2smx!4v1677733866626!5m2!1ses-419!2smx', 'created_at' => now()]
        ];

        Branch::insert($records);
    }
}
