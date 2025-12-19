<?php

use App\Http\Controllers\Page\CommentController;
use App\Http\Controllers\Page\ItemController;
use App\Http\Controllers\Page\LikeController;
use App\Http\Controllers\Page\ProfileController;
use App\Http\Controllers\Page\PurchaseController;
use App\Http\Controllers\Page\SellController;
use App\Http\Controllers\Page\TopController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopController::class, 'index'])
    ->name('top');

Route::get('/item/{item_id}', [ItemController::class, 'show'])
    ->name('item.show');

Route::get('/purchase/success', [PurchaseController::class, 'success'])
    ->name('purchase.success');

Route::get('/purchase/cancel', [PurchaseController::class, 'cancel'])
    ->name('purchase.cancel');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('mypage.edit');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function () {
        request()->user()->sendEmailVerificationNotification();

        return back()->with('message', '認証メールを再送信しました。');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'confirm'])
        ->whereNumber('item_id')
        ->name('purchase.confirm');

    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])
        ->whereNumber('item_id')
        ->name('purchase.exec');

    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])
        ->whereNumber('item_id')
        ->name('purchase.address');

    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'addressUpdate'])
        ->whereNumber('item_id')
        ->name('purchase.address.update');

    Route::get('/sell', [SellController::class, 'create'])
        ->name('sell.create');

    Route::post('/sell', [SellController::class, 'store'])
        ->name('sell.store');

    Route::get('/mypage', [ProfileController::class, 'show'])
        ->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('mypage.edit');

    Route::post('/mypage/profile', [ProfileController::class, 'update'])
        ->name('mypage.update');

    Route::post('/item/{item}/like', [LikeController::class, 'store'])
        ->name('item.like');

    Route::delete('/item/{item}/like', [LikeController::class, 'delete'])
        ->name('item.unlike');

    Route::post('/item/{item}/comment', [CommentController::class, 'store'])
        ->name('item.comment.store');

});
