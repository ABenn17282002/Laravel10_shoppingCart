<?php

// Admin用クラスをインポート
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\Auth\AdminProfileController; // ← route情報変更
use Illuminate\Support\Facades\Route;
// Ownerコントローラーの使用
use App\Http\Controllers\Admin\OwnersController;
// CategoryControllerコントローラーの使用
use App\Http\Controllers\Admin\CategoryController;
/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// 管理者用Dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

// auth.phpの引用
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// auth.phpの引用+Adminモデル
Route::middleware('auth:admin')->group(function () {
    // ログイン機能
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // adminプロフィール編集用
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// リソースコントローラ(show画面を除外したルーティング)
Route::resource('owners', OwnersController::class)
->middleware('auth:admin')->except(['show']);

// カテゴリー情報
Route::prefix('categories')->middleware('auth:admin')->group(function () {
    // カテゴリー一覧
    Route::get('/', [CategoryController::class, 'Primaryindex'])->name('categories.index');
    // プライマリーソートオーダー並び替え
    Route::patch('/{Primary_id}', [CategoryController::class, 'sortOrderUpdate'])->name('categories.Primaryorder_update');
    // カテゴリー新規作成+登録
    Route::get('/create', [CategoryController::class, 'Categorycreate'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('categories.store');
    // カテゴリーの編集
    Route::get('/{primaryCategory}', [CategoryController::class, 'CategoryEdit'])->name('categories.edit');
    // カテゴリーの更新(引数:id)
    Route::put('/{id}', [CategoryController::class, 'CategoryUpDate'])->name('categories.update');
    // セカンダリーカテゴリの削除
    Route::post('/categories/delete/{second_id}', [CategoryController::class, 'deleteSecondaryCategory'])->name('categories.deleteSecondary');
    // プライマリーカテゴリー情報の削除
    Route::delete('/{id}', [CategoryController::class, 'CategoryTrash'])->name('categories.trash');
});

// 削除済みカテゴリー情報（一覧+削除+復元）
Route::prefix('expired-categories')->
    middleware('auth:admin')->group(function(){
        Route::get('index', [CategoryController::class, 'expiredCatergoryIndex'])->name('expired-categories.index');
        Route::get('show/{category}', [CategoryController::class, 'ExpiredCategoryShow'])->name('expired-categories.show');
        Route::post('destroy/{category}', [CategoryController::class, 'expiredCatergoryDestroy'])->name('expired-categories.destroy');
        Route::post('restore/{category}', [CategoryController::class, 'restoreCategory'])->name('expired-categories.restore');
});

// 削除済みOwner一覧表示及び物理削除用ルート
Route::prefix('expired-owners')->
    middleware('auth:admin')->group(function(){
        Route::get('index', [OwnersController::class, 'expiredOwnerIndex'])->name('expired-owners.index');
        Route::post('destroy/{owner}', [OwnersController::class, 'expiredOwnerDestroy'])->name('expired-owners.destroy');
});
