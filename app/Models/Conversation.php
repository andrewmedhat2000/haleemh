<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function withUser($unset = true)
    {
        if($this->relationLoaded('users')){
            $this->setRelation('user', $this->users->where('id', '!=', Auth::id())->first());
            if($unset) $this->unsetRelation('users');
        }
    }
}
