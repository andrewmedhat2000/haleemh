<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $table='facility';
   protected $fillable = [
    'space', 'num_of_rooms', 'setter_id', 'image ','tax_id', 'rent_contract','name'
        ];

        protected $appends = [
            'tax_id_url',
            'rent_contract_url'
        ];
        public $upload_distination = '/uploads/images/facilities/';

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


     public function rooms()
     {
        return $this->hasMany(Room::class);
    }
     public function setTaxIdAttribute($value)
     {
         if (!$value instanceof UploadedFile) {
             $this->attributes['tax_id'] = $value;
             return;
         }
         $image_name = str::random(60);
         $image_name = $image_name . '.' . $value->getClientOriginalExtension(); // add the extention
         $value->move(public_path($this->upload_distination), $image_name);
         $this->attributes['tax_id'] = $image_name;
     }
     public function getTaxIdUrlAttribute()
     {
         if (!$this->tax_id) {
             return asset('/panel-assets/images/profile-picutre/01_img.png');
         }
         return strpos($this->tax_id, 'http') !== false ? $this->tax_id : asset($this->upload_distination . $this->tax_id);
     }


     public function setRentContractAttribute($value)
     {
         if (!$value instanceof UploadedFile) {
             $this->attributes['rent_contract'] = $value;
             return;
         }
         $image_name = str::random(60);
         $image_name = $image_name . '.' . $value->getClientOriginalExtension(); // add the extention
         $value->move(public_path($this->upload_distination), $image_name);
         $this->attributes['rent_contract'] = $image_name;
     }
     public function getRentContractUrlAttribute()
     {
         if (!$this->rent_contract) {
             return asset('/panel-assets/images/profile-picutre/01_img.png');
         }
         return strpos($this->rent_contract, 'http') !== false ? $this->rent_contract : asset($this->upload_distination . $this->rent_contract);
     }

}
