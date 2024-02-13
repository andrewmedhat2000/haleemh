<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\API\ChatController::class, 'send']);
Route::get('/listen', function () {
    return view('listen');
});
//Route::post('chat/send_message',[App\Http\Controllers\API\ChatController::class, 'send']);

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::group(['prefix' => 'dashboard'], function () {
        Route::resource('users', \App\Http\Controllers\dashboard\UserController::class)->names('dashboard.users');
        Route::resource('setters', \App\Http\Controllers\dashboard\SetterController::class)->names('dashboard.setters');
        Route::resource('nursery', \App\Http\Controllers\dashboard\NurseryController::class)->names('dashboard.nursery');
        Route::resource('rooms', \App\Http\Controllers\dashboard\RoomController::class)->names('dashboard.rooms');
        Route::resource('certificates', \App\Http\Controllers\dashboard\CertificateController::class)->names('dashboard.certificate');
        Route::resource('facility', \App\Http\Controllers\dashboard\FacilityController::class)->names('dashboard.facility');
        Route::resource('setter_rate', \App\Http\Controllers\dashboard\SetterRateController::class)->names('dashboard.setter_rate');
        Route::match(['POST'], 'user_details', [\App\Http\Controllers\dashboard\SetterController::class, 'user_details'])->name('dashboard.setters.user_details');
        Route::match(['POST'], 'certificate_details', [\App\Http\Controllers\dashboard\SetterController::class, 'certificates_details'])->name('dashboard.setters.certificate_details');
        Route::match(['POST'], 'facility_details', [\App\Http\Controllers\dashboard\SetterController::class, 'facility_details'])->name('dashboard.setters.facility_details');
        Route::match(['POST'], 'setter_rate_details', [\App\Http\Controllers\dashboard\SetterController::class, 'setter_rate_details'])->name('dashboard.setters.setter_rate_details');
        Route::match(['POST'], 'room_details', [\App\Http\Controllers\dashboard\SetterController::class, 'room_details'])->name('dashboard.setters.room_details');
        Route::match(['POST'], 'nursery_details', [\App\Http\Controllers\dashboard\SetterController::class, 'nursery_details'])->name('dashboard.setters.nursery_details');
    });
    //Route::get('users', [\App\Http\Controllers\dashboard\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
