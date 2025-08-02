<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Inertia\Inertia;
use App\Http\Controllers\ChatRoomController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

# Star Region of WebChat
Route::get('/webchat', function () {
    return Inertia::render('WebChat');
})->middleware(['auth', 'verified'])->name('WebChatRoom');

Route::post('/send-message', function (Request $request) {
    $message = $request->input('message'); // lebih aman
    if (!$message) {
        return response()->json(['error' => 'No message provided'], 422);
    }
    Log::info("Route hit, message: " . $message);
    event(new MessageSent($message));

    return response()->json(['status' => 'sent']);
});
Route::get('/send-message', function () {
    event(new MessageSent("Bisa kok"));

    return 'Succes';
});
Route::get('/get-user', [ChatRoomController::class, '']);
# End Region of WebChat

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
