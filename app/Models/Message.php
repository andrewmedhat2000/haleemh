<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Message extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['conversation_id', 'user_id', 'text'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
