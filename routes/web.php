<?php

use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\LifeCycleTestController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\MyPageController;
use App\Http\Controllers\User\PrivacyController;
use App\Http\Controllers\User\TermsController;
use App\Http\Controllers\User\TokushohoController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;

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

Route::get('/welcome', function () {
    return view('user.welcome');
});


Route::middleware('auth:users')->group(function(){
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
    Route::get('show/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('terms', [TermsController::class, 'index'])->name('terms.index');
    Route::get('mypage', [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('tokushoho', [TokushohoController::class, 'index'])->name('tokushoho.index');
    Route::get('privacy', [PrivacyController::class, 'index'])->name('privacy.index');
});

Route::prefix('cart')->middleware('auth:users')->group(function(){
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('add', [CartController::class, 'add'])->name('cart.add');
    Route::post('delete/{item}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('success', [CartController::class, 'success'])->name('cart.success');
    Route::get('cancel', [CartController::class, 'cancel'])->name('cart.cancel');
});

Route::prefix('contact')->middleware('auth:users')->group(function(){
    Route::get('/', [ContactController::class, 'index'])->name('contact.index');
    Route::post('confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('thanks', [ContactController::class, 'send'])->name('contact.send');
});

require __DIR__.'/auth.php';
