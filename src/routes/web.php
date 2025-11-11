<?php

use App\Http\Controllers\Page\ItemController;
use App\Http\Controllers\Page\ProfileController;
use App\Http\Controllers\Page\PurchaseController;
use App\Http\Controllers\Page\SellController;
use App\Http\Controllers\Page\TopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//PG01 & PG02: 商品一覧画面（トップ画面）/ マイリストはクエリで分岐する(/?page=mylist)
Route::get('/', [TopController::class, 'index'])
    ->name('top');

//PG03 & PG04: 会員登録画面,ログイン画面 はFortifyの既定ルートを使用する

//PG05: 商品詳細画面
Route::get('/item/{item_id}', [ItemController::class, 'show'])
    ->name('item.show');

Route::middleware('auth')->group(function(){
    //PG06: 商品購入画面
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'confirm'])
        ->name('purchase.confirm');

    //PG07: 送付先住所変更画面
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])
        ->name('purchase/address');

    //PG08: 商品出品画面
    Route::get('/sell', [SellController::class, 'create'])
        ->name('sell.create');
    //PG09: プロフィール画面
    Route::get('/mypage', [ProfileController::class, 'show'])
        ->name('mypage');
    //PG10:　プロフィール編集画面（設定画面）
    Route::get('mypage/profile', [ProfileController::class, 'edit'])
        ->name('mypage.edit');
    //PG11/PG12: 購入した商品一覧, 出品した商品一覧（プロフィール画面）
    Route::get('/mypage/list', [ProfileController::class, 'list'])
        ->name('mypage.list');
});