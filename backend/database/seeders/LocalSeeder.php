<?php

namespace Database\Seeders;
//追加
use App\Models\Channel;
use App\Models\Message;
//
use App\Models\Attachment;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->create([
        //     'email' => 'test@example.com',
        //     'nickname' => 'テストユーザー',
        // ]);
        // User::factory()->create([
        //     'email' => 'test2@example.com',
        //     'nickname' => 'テストユーザー2',
        // ]);
        // User::factory()
        //     ->count(8)
        //     ->create();
        // //
        // // //追加
        // // Channel::create([
        // //         'uuid' =>  \Str::uuid(),
        // //         'name' => 'Testチャンネル',
        // //     ]);

        // // 「Factoryの定義に合わせて、１０件のデータをつくってくれー」って感じの指定です
        // // Channel::factory()
        // $channels = Channel::factory()
        //     ->count(10)->create();
        // // ↑で作ったチャンネルに紐づくメッセージを作成（１チャンネル１０メッセージ作成）
        // foreach ($channels as $channel) {
        //     Message::factory()
        //         ->count(10)
        //         ->create([
        //             'channel_id' => $channel->id,
        //         ]);
        // }

        // Attachment::factory()
        //     ->count(10)
        //     ->create();

        $testUser = User::factory()->create([
            'email' => 'test@example.com',
            'nickname' => 'テストユーザー',
        ]);
        User::factory()->create([
            'email' => 'test2@example.com',
            'nickname' => 'テストユーザー2',
        ]);
        $users = User::factory()
            ->count(8)
            ->create();

        Channel::factory()
            ->hasAttached($users->random(3)->push($testUser))
            ->create([
                'name' => 'Quiet Room',
            ]);

        Channel::factory()
            ->hasAttached($users->push($testUser))
            ->has(
                Message::factory()
                    ->count(100)
                    ->recycle($users)
            )
            ->create([
                'name' => 'Noisy Room',
            ]);

        Channel::factory()
            ->hasAttached($randomUsers = $users->random(5)->push($testUser))
            ->has(
                Message::factory()
                    ->count(10)
                    ->recycle($randomUsers)
            )
            ->create([
                'name' => 'Normal Room',
            ]);
    }
}
