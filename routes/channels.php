<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;



/*
Broadcast::channel('conversation.{id}', function () {
    return true;
});
*/
Broadcast::channel('conversation.{id}', function ($user, $conversation_id) {
    return DB::table('conversation_user')->where([['user_id', $user->id],['conversation_id', $conversation_id]])->exists();
});
