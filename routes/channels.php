<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{id}', function (User $user, $id) {
    return $user->only('id', 'name', 'email');
});

// Broadcast::channel('group.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
