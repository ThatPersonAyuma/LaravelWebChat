<?php

use Illuminate\Support\Facades\Broadcast;

# Private Channel, gunakan id dari database, untuk sekarang static saja
Broadcast::channel('ChatRoom', function () {
    return true;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
