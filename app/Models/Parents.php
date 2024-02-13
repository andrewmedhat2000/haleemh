<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Parents extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='parents';
   protected $fillable = [
    'user_id '
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


     public function orders()
     {
         return $this->hasMany(Order::class);
     }
     public function childrens()
     {
        return $this->hasMany(Children::class, 'parent_id');
    }
     public function drivers()
     {
         return $this->hasMany(Driver::class,'parent_id');
     }
     public function reports()
     {
         return $this->hasMany(Report::class,'parent_id');
     }
     public function user()
     {
         return $this->belongsTo(User::class);
     }

     public function favorites()
     {
         return $this->hasMany(Favourite::class);
     }
}
