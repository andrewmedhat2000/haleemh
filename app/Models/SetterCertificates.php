<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SetterCertificates extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $table='certificates';
   protected $fillable = [
    'setter_id','image', 'certificate_name'
        ];

        protected $appends = [
            'image_url',
        ];
        public $upload_distination = '/uploads/images/setters_certificates/';

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
        return $this->belongsTo(Setter::class);
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
