<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Inertia\Inertia;
use App\Http\Controllers\ChatRoomController;

Route::middleware('api')->group(function () {
    Route::get('/get-user', [ChatRoomController::class, 'get_all']);

    Route::get('/get-user-chat-rooms', [ChatRoomController::class, 'get_chat_rooms']);

    Route::get('/get-user-cr-messages', [ChatRoomController::class, 'get_cr_messages']);
    
    Route::get('/get-group-by-id', [ChatRoomController::class, 'get_group_by_id']);

    Route::get('/get-user-by-id', [ChatRoomController::class, 'get_user_by_id']);
});
