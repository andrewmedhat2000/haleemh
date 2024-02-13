<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Room extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $table='rooms';
   protected $fillable = [
    'setter_id','name','facility_id'
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



     public function rooms_images()
     {
         return $this->hasMany(RoomImages::class);
     }
     public function setter()
     {
         return $this->belongsTo(Setter::class);
     }
     public function facility()
     {
         return $this->belongsTo(Facility::class);
     }
     public function images()
     {
         return $this->belongsToMany(Image::class, 'room_images','room_id','image_id')->withTimestamps();
     }


}
