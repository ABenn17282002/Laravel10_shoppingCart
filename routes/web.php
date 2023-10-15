<?php

use Illuminate\Support\Facades\Route;

// ComponentTESTpage表示のためのクラス追加
use App\Http\Controllers\Component\ComponentTestController;
// ServiceContainer表示用クラス追加
use App\Http\Controllers\LifeCycleTestController;

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

Route::get('/', function () {
    return view('user.welcome');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth:users', 'verified'])->name('dashboard');

// ComponentTespage表示
Route::get('/component-test1',[ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2',[ComponentTestController::class, 'showComponent2']);

// ServiceContainer表示
Route::get('/servicecontainertest',[LifeCycleTestController::class, 'showServiceContainerTest']);

// ServiceProvider表示
Route::get('/serviceprovidertest',[LifeCycleTestController::class, 'showServiceProviderTest']);

require __DIR__.'/auth.php';
