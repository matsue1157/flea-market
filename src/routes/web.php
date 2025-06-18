<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LikeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

// トップページ（認証不要）
Route::get('/', fn() => view('welcome'));

// 商品一覧（認証不要）
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 認証済・メール認証済ユーザー専用ルート（出品・コメント・いいね・購入など）
Route::middleware(['auth', 'verified'])->group(function () {
    // 出品
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // コメント投稿
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');

    // いいね
    Route::post('/products/{product}/like', [LikeController::class, 'store'])->name('products.like');
    Route::delete('/products/{product}/like', [LikeController::class, 'destroy'])->name('products.unlike');

    // 購入
    Route::get('/products/{product}/purchase', [PurchaseController::class, 'create'])->name('purchases.create');
Route::post('/products/{product}/purchase', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/profile/purchases', [ProfileController::class, 'purchasedProducts'])->name('profile.purchases');

    // 購入した商品一覧ページ
    Route::get('/profile/purchases', [ProfileController::class, 'purchasedProducts'])->name('profile.purchases');
    // web.php
    Route::post('/purchase/{product}', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/success', [PurchaseController::class, 'success'])->name('purchase.success');


    // ダッシュボード
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::get('/likes', [LikeController::class, 'index'])->name('likes.index');

    // ログアウト
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

// 商品詳細（最後に定義）
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// メール認証関連（ログイン後のみ表示）
Route::get('/email/verify', fn() => view('auth.verify-email'))->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.edit');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証リンクを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// メール送信テスト
Route::get('/test-mail', function () {
    Mail::raw('MailHog test message', function ($message) {
        $message->to('test@example.com')->subject('Test Mail from Laravel');
    });
    return 'Sent';
});