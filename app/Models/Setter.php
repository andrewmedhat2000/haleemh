<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Setter extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='setter';
   protected $fillable = [
    'hour_price', 'long', 'lat', 'user_id ','hint','nursery_id', 'Professional_life', 'completed_orders'
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
     public function rooms()
     {
         return $this->hasMany(Room::class);
     }


     public function certificates()
     {
         return $this->hasMany(SetterCertificates::class);
     }
     public function facility()
    {
        return $this->hasOne(Facility::class);
    }
     public function nursery()
     {
         return $this->belongsTo(Nursery::class);
     }
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favourite::class);
    }
     public function reports()
     {
         return $this->hasMany(Report::class,'setter_id');
     }
}
