<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('chat');



Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/create', [ChatController::class, 'createChatRoom'])->name('chat.create');
Route::post('/chat/store', [ChatController::class, 'storeChatRoom'])->name('chat.store');
Route::get('/chat/{roomID}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/{roomID}/send', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
Route::get('/chat/{roomID}/add-participants', [ChatController::class, 'addParticipantsForm'])->name('chat.addParticipantsForm');
Route::post('/chat/{roomID}/add-participants', [ChatController::class, 'addParticipants'])->name('chat.addParticipants');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



