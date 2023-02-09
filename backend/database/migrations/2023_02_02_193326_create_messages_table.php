<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('channel_id')->unique();
            // $table->unsignedBigInteger('user_id')->unique();
            // $table->text('content');
            // $table->timestamps();
            $table
            // チャンネルIDとの紐付け変なデータが入らない
                ->foreignId('channel_id')
                ->constrained('channels')
                // cascade 対応するデータが消えた時どうするか設定してる。
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('content')->nullable();
            $table->timestamps(3); // ミリ秒まで保存可能とする

            $table->index('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
