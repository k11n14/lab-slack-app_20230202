<?php

namespace Database\Seeders;
//追加
use App\Models\Channel;
//
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // //追加
        // Channel::create([
        //         'uuid' =>  \Str::uuid(),
        //         'name' => 'Testチャンネル',
        //     ]);

        // 「Factoryの定義に合わせて、１０件のデータをつくってくれー」って感じの指定です
        Channel::factory()->count(10)->create();
    }
}
