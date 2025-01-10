<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('my-channel.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
