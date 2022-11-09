<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TimeSlotController;
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

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| TIMESLOT CREATE STORE
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'time_slot'], function () {
    Route::get('create',[TimeSlotController::class,'create'])->name('time_slot.create');
    Route::post('store',[TimeSlotController::class,'store'])->name('time_slot.store');
});

/*
|--------------------------------------------------------------------------
| APPOINTMENT CREATE STORE
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'appointment'], function () {
    Route::get('create',[AppointmentController::class,'createAppointment'])->name('appointment.create');
    Route::post('store',[AppointmentController::class,'bookAppointment'])->name('appointment.store');
    Route::post('get_slot',[AppointmentController::class,'getSlot'])->name('appointment.get_slot');
});
