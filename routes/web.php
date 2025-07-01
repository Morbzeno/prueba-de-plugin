<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Morbzeno\PruebaDePlugin\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\BlogController;

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']);

Route::get('/blog', [BlogController::class,'showblogs']);

Route::get('/blog/{slug}', [BlogController::class, 'detailBlog']);

Route::get('/tag/{slug}', [BlogController::class, 'showtag']);

Route::get('/category/{slug}', [BlogController::class, 'showcategory']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \Morbzeno\PruebaDePlugin\Models\User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link');
    }

    Auth::login($user);

    if ($user->hasVerifiedEmail()) {
        return redirect('/luis')->with('message', 'Email already verified.');
    }

    if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    return redirect(filament()->getUrl())->with('message', 'Email verified!');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', '¡El enlace de verificación ha sido enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


