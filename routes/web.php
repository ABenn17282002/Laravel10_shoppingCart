<?php

use Illuminate\Support\Facades\Route;

// ComponentTESTpage表示のためのクラス追加
use App\Http\Controllers\Component\ComponentTestController;
// ServiceContainer表示用クラス追加
use App\Http\Controllers\LifeCycleTestController;
use GuzzleHttp\Middleware;
// ItemController表示用クラスの追加
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

// 商品一覧ページ用ルート
Route::middleware('auth:users')->group(function(){
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
});

// ComponentTespage表示
Route::get('/component-test1',[ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2',[ComponentTestController::class, 'showComponent2']);

// ServiceContainer表示
Route::get('/servicecontainertest',[LifeCycleTestController::class, 'showServiceContainerTest']);

// ServiceProvider表示
Route::get('/serviceprovidertest',[LifeCycleTestController::class, 'showServiceProviderTest']);

require __DIR__.'/auth.php';
