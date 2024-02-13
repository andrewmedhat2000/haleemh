<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Nursery extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $table='nursery';
   protected $fillable = [
    'hour_price', 'long', 'lat','hint','image', 'completed_orders','name'
        ];

        protected $appends = [
            'image_url',
        ];
        public $upload_distination = '/uploads/images/nurseries/';

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



     public function setters()
     {
         return $this->hasMany(Setter::class);
     }
     public function rates()
     {
         return $this->hasMany(NurseryRate::class);
     }

     public function setImageAttribute($value)
     {
         if (!$value instanceof UploadedFile) {
             $this->attributes['image'] = $value;
             return;
         }
         $image_name = str::random(60);
         $image_name = $image_name . '.' . $value->getClientOriginalExtension(); // add the extention
         $value->move(public_path($this->upload_distination), $image_name);
         $this->attributes['image'] = $image_name;
     }
     public function getImageUrlAttribute()
     {
         if (!$this->image) {
             return asset('/panel-assets/images/profile-picutre/01_img.png');
         }
         return strpos($this->image, 'http') !== false ? $this->image : asset($this->upload_distination . $this->image);
     }

}
