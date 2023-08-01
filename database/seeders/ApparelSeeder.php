<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApparelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apparel_data = [

            // Admin

            [
                'title' => 'Tops',
                'order_id' => 1,
            ],
            [
                'title' => 'Bottom',
                'order_id' => 2,
            ],
            [
                'title' => 'Outwear',
                'order_id' => 3,
            ],
            [
                'title' => 'Accesories',
                'order_id' => 4,
            ],
            [
                'title' => 'Sunglasses',
                'order_id' => 5,
            ],
            [
                'title' => 'Intimates',
                'order_id' => 6,
            ],
            [
                'title' => 'Underwear',
                'order_id' => 7,
            ],
            [
                'title' => 'Wedding and Events',
                'order_id' => 8,
            ],



        ];

        DB::table('apparels')->insert($apparel_data);
    }
}
