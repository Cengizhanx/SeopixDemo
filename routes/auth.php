<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OffDayController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// Giriş yapmamış kullanıcılar - Ziyaretçi
Route::middleware('guest')->group(function () {
    Route::get('giris-yap', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('giris-yap', [AuthenticatedSessionController::class, 'store']);

    Route::get('/kariyer', [CareerController::class, 'showForm']);

    Route::post('/verify-tckimlik', [CareerController::class, 'verifyTCKimlik']);
    Route::post('/submit-career-form', [CareerController::class, 'submitCareerForm']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Giriş yapan Admin
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('kayit-olustur', [RegisteredUserController::class, 'create'])->middleware(['auth'])
        ->name('register');
    Route::post('kayit-olustur', [RegisteredUserController::class, 'store'])->middleware(['auth']);

    Route::get('/personel-listesi', [AdminController::class, 'show'])->name('admin.personal-list');
    Route::get('/personel/duzenle/{id}', [AdminController::class, 'edit'])->name('admin.personel-edit');
    Route::put('/personel/{id}', [AdminController::class, 'update'])->name('admin.personel-update');

    Route::get('/izin-listesi', [OffDayController::class, 'show'])->name('admin.offday-list');
    // Route::get('/izin-listesi', [OffdayController::class, 'offdayFilter'])->name('admin.offday-list');
    Route::post('/izin-listesi/izin-onayla/{id}', [OffDayController::class, 'toggleApproved'])->name('auth.toggle-approved');
    Route::post('/izin-listesi/izin-reddet/{id}', [OffDayController::class, 'toggleRejected'])->name('auth.toggle-rejected');

    Route::post('/personel-listesi/rol-değiştir/{id}', [AdminController::class, 'toggleRole'])->name('admin.toggle-role');
    Route::delete('/personel-listesi/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('/istek-listesi', [DemandController::class, 'index'])->name('admin.demand-list');
    Route::get('/istek-listesi', [DemandController::class, 'demandFilter'])->name('admin.demand-list');
    Route::post('/istek-listesi/onayla/{id}', [DemandController::class, 'approve'])->name('admin.demand-approve');
    Route::post('/istek-listesi/reddet/{id}', [DemandController::class, 'reject'])->name('admin.demand-reject');
    Route::delete('/istek-listesi/sil/{id}', [DemandController::class, 'delete'])->name('admin.demand-delete');

    Route::get('/basvurular', [CareerController::class, 'getApp'])->name('career.list');
    Route::post('basvurular/personal-ata/{careerId}', [CareerController::class, 'appointPersonal'])->name('admin.appoint-personal');
    Route::delete('/basvuru/sil/{careerId}', [CareerController::class, 'deleteCareer'])->name('admin.career-delete');


});

// Giriş yapan Personel
Route::middleware(['auth', CheckRole::class . ':personal'])->group(function () {

    Route::get('/izin-talebi', [OffDayController::class, 'addRequest'])->name('personal.request-offday');
    Route::post('izin-talebi', [OffDayController::class, 'store'])->name('personal.request-offday');
    Route::get('/izin-durumlari', [OffDayController::class, 'myRequests'])->name('personal.offday-status');


    Route::get('/istekler', [DemandController::class, 'create'])->name('personal.demands');
    Route::post('/istekler', [DemandController::class, 'store'])->name('personal.demands-store');
    Route::put('/demands/{id}', [DemandController::class, 'update'])->name('personal.update-demand');


});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/etkinlikler', [EventController::class, 'index'])->name('auth.events');
    Route::get('/etkinlikler/list', [EventController::class, 'eventControl']);
    Route::post('/etkinlikler/olustur', [EventController::class, 'createEvent']);
    Route::get('/etkinlikler/{eventId}/pozisyon', [EventController::class, 'eventPositions']);
    Route::delete('/etkinlikler/{id}', [EventController::class, 'destroy']);
    Route::patch('/etkinlikler/{event}/durum', [EventController::class, 'updateStatus']);
    Route::patch('/etkinlikler/{id}/taşı', [EventController::class, 'moveEvent']);


    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Route::get('/request-offday', [OffDayController::class, 'addRequest'])->name('auth.request-offday');
    // Route::post('request-offday', [OffDayController::class, 'store'])->name('auth.request-offday');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout'); 
});
