<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
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

Route::get('/signin', [AuthController::class, 'index_of_signin'])->name('signin')->middleware('guest');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin.action')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/chart/admin-count', [DashboardController::class, 'getAdminCount'])->name('chart.admin');
    Route::get('/chart/event-count', [DashboardController::class, 'getEventCount'])->name('chart.event');
    Route::get('/chart/events-by-month', [DashboardController::class, 'getEventsByMonth'])->name('chart.eventByMonth');


    Route::post('/my-profile/update/{id}', [AdminController::class, 'update_profile'])->name('my-profile.update');

    Route::get('/all-administrators', [AdminController::class, 'all'])->name('all-administrators');
    Route::post('/all-administrators/add', [AdminController::class, 'create'])->name('all-administrators.add');
    Route::post('/all-administrators/edit/{id}', [AdminController::class, 'update'])->name('all-administrators.edit');
    Route::get('/all-administrators/delete/{id}', [AdminController::class, 'delete'])->name('all-administrators.delete');
    Route::get('/all-administrators/restore/{id}', [AdminController::class, 'restore'])->name('all-administrators.restore');

    Route::get('/events', [EventController::class, 'all'])->name('events');
    Route::get('/events/detail/{id}', [EventController::class, 'detail'])->name('events.detail');
    Route::post('/events/detail/edit/{id}', [EventController::class, 'update'])->name('events.edit');
    Route::get('/events/create-new', [EventController::class, 'index_of_create'])->name('events.create-new');
    Route::get('/events/create-new/set-default-style', [EventController::class, 'set_default_style'])->name('events.set-default-style');
    Route::post('/events/add', [EventController::class, 'create'])->name('events.add');
    Route::get('/events/delete/{id}', [EventController::class, 'delete'])->name('events.delete');
    Route::get('/events/restore/{id}', [EventController::class, 'restore'])->name('events.restore');
    Route::get('/events/qr-code/{id}', [EventController::class, 'qr_code'])->name('events.qr-code');

    Route::get('/events/start-livechat/{id}', [EventController::class, 'start_livechat'])->name('events.start-livechat');
    Route::get('/events/stop-livechat/{id}', [EventController::class, 'stop_livechat'])->name('events.stop-livechat');

    Route::delete('/events/livechat/delete-chat/{id_event}/{id_chat}', [EventController::class, 'delete_chat'])->name('events.delete-livechat');
});


Route::get('/events/history-livechat/{id}', [EventController::class, 'history_livechat'])->name('events.history-livechat');

Route::get('/events/demo/videotron/{id}', [EventController::class, 'demo_videotron'])->name('events.demo-videotron');
Route::get('/events/demo/visitor/{id}', [EventController::class, 'demo_visitor'])->name('events.demo-visitor');

Route::get('/events/livechat/videotron/{id}', [EventController::class, 'livechat_videotron'])->name('events.livechat-videotron');
Route::get('/events/livechat/get-videotron/{id}', [EventController::class, 'get_chat_videotron'])->name('events.get-chat-videotron');

Route::get('/events/livechat/visitor/{id}', [EventController::class, 'livechat_visitor'])->name('events.livechat-visitor');
Route::get('/events/livechat/get-visitor/{id}', [EventController::class, 'get_chat_visitor'])->name('events.get-chat-visitor');

// Route::post('/events/livechat/send/{id}', [EventController::class, 'send_chat'])->name('events.send-chat')->middleware('throttle:chat');
Route::post('/events/livechat/send/{id}', [EventController::class, 'send_chat'])->name('events.send-chat');


// Route::get('/events/test', [EventController::class, 'testPusher']);
