<?php

use Illuminate\Support\Facades\Route;

// ComponentTESTpage表示のためのクラス追加
use App\Http\Controllers\Component\ComponentTestController;
// ServiceContainer表示用クラス追加
use App\Http\Controllers\LifeCycleTestController;
use GuzzleHttp\Middleware;
// ItemControllerクラスの追加
use App\Http\Controllers\User\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 商品一覧+詳細ページ
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('show/{item}', [ItemController::class, 'show'])->name('items.show');

// USERLOGIN時の挙動
Route::middleware('auth:users')->group(function(){
    Route::get('/member', [ItemController::class, 'memberIndex'])->name('items.memberIndex');
    Route::get('/member/show/{item}', [ItemController::class, 'show'])->name('items.membershow');
});

// ComponentTespage表示
Route::get('/component-test1',[ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2',[ComponentTestController::class, 'showComponent2']);

// ServiceContainer表示
Route::get('/servicecontainertest',[LifeCycleTestController::class, 'showServiceContainerTest']);

// ServiceProvider表示
Route::get('/serviceprovidertest',[LifeCycleTestController::class, 'showServiceProviderTest']);

require __DIR__.'/auth.php';
