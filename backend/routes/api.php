<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\MyResourceController;
// use App\Http\Controllers\Api\ChannelController;

// // use App\Http\Controllers\Auth;
// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware(['auth:sanctum'])
//     ->name('api.')
//     ->group(function () {
//         // POSTなので、Route::post()
//         // エンドポイントは、/channels
//         Route::post('/channels', function (Request $request) {
//             // とりあえず、ベタ書きでレスポンスする
//             // レスポンスの形をswaggerと合わせる
//             return response()->json([
//                 'id' => 1,
//                 'uuid' => \Str::uuid(),
//                 'name' => 'テストチャンネルの名前',
//                 'joined' => true,
//             ]);
//         });

//         // Route::get('/me', function (Request $request) {
//         //     return response()->json([
//         //         'id' => 1,
//         //         'uuid' => \Str::uuid(),
//         //         'name' => 'テストチャンネルの名前',
//         //         'joined' => true,
//         //     ]);
//         // });
//         Route::get('/me', [MyResourceController::class, 'me'])->name('me');

//         Route::post('/my/icons', function () {
//             return "http://localhost/users/image/1";
//         });

//         // Route::get('/my/channels', function () {
//         //     //  return response()->json([
//         //     //         [
//         //     //             'id' => 1,
//         //     //             'uuid' => \Str::uuid(),
//         //     //             'name' => 'テストチャンネルの名前1',
//         //     //             'joined' => true,
//         //     //         ]
//         //     // );
//         //     return response()->json([
//         //         [
//         //             'id' => 1,
//         //             'uuid' => \Str::uuid(),
//         //             'name' => 'テストチャンネルの名前1',
//         //             'joined' => true,
//         //         ],
//         //     ]);
//         // });
//         Route::prefix('/channels')
//             ->name('channels.')
//             ->group(function () {
//                 Route::post('', [ChannelController::class, 'store'])->name(
//                     'store'
//                 );
//             });
// });

// <?php

use App\Http\Controllers\Api\AttachmentController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\MyResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])
    ->name('api.')
    ->group(function () {
        Route::get('/me', [MyResourceController::class, 'me'])->name('me');

        Route::prefix('/my')
            ->name('my.')
            ->group(function () {
                Route::post('/icons', [MyResourceController::class, 'updateIcons'])
                    ->name('icons');

                Route::get('/channels', [MyResourceController::class, 'channels'])
                    ->name('channels');
            });

        Route::prefix('/channels')
            ->name('channels.')
            ->group(function () {
                Route::get('', [ChannelController::class, 'index'])->name('index');

                Route::post('', [ChannelController::class, 'store'])->name('store');

                Route::prefix('/{uuid}')->group(function () {
                    Route::prefix('/messages')
                        ->name('messages.')
                        ->group(function () {
                            Route::get('', [MessageController::class, 'index'])
                                ->name('index');

                            Route::get('/polling', [MessageController::class, 'polling'])
                                ->name('polling');

                            Route::post('', [MessageController::class, 'store'])
                                ->name('store');

                            Route::delete('/{id}', [MessageController::class, 'destroy'])
                                ->name('destroy');
                        });

                    Route::post('/attachments', [AttachmentController::class, 'storeAttachmentFile'])
                        ->name('attachments');

                    Route::post('/join', [ChannelController::class, 'join'])
                        ->name('join');

                    Route::post('/leave', [ChannelController::class, 'leave'])
                        ->name('leave');
                });
            });
    });
