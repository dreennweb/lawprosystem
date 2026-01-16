<?php

use App\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function (User $user, int $id) {
    return (int) $user->id === (int) $id;
});
