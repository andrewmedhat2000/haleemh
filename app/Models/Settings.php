<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Settings extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'settings';

    protected $fillable = [
        'about_en',
        'about_ar',
        'policy_en',
        'policy_ar',
        'cancellation_fees',
    ];
}
