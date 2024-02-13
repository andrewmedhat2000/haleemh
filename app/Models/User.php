<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='users';
   protected $fillable = [
    'name', 'email', 'phone', 'nationality','national_id', 'address', 'date_of_birth', 'gender', 'image','role','password','verification_code','verification_code_expiry','phone_code','fcm_key'
];
protected $appends = [
    'image_url',
    'national_id_url'
];
public $upload_distination = '/uploads/images/users/';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token','password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

/*
     public function setPasswordAttribute($value)
     {
         if (!empty($value)) {
             $this->attributes['password'] = bcrypt($value);
         }
     }
     */

     public function setNationalIdAttribute($value)
     {
         if (!$value instanceof UploadedFile) {
             $this->attributes['national_id'] = $value;
             return;
         }
         $image_name = str::random(60);
         $image_name = $image_name . '.' . $value->getClientOriginalExtension(); // add the extention
         $value->move(public_path($this->upload_distination), $image_name);
         $this->attributes['national_id'] = $image_name;
     }
     public function getNationalIdUrlAttribute()
     {
         if (!$this->national_id) {
             return asset('/panel-assets/images/profile-picutre/01_img.png');
         }
         return strpos($this->national_id, 'http') !== false ? $this->national_id : asset($this->upload_distination . $this->national_id);
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
    public function setter()
    {
        return $this->hasOne(Setter::class);
    }
    public function parent()
    {
        return $this->hasOne(Parents::class);
    }
    public function messages()
     {
         return $this->hasMany(Message::class);
     }
     public function transactions()
    {
       return $this->hasMany(Transaction::class);
    }
    public function rates()
    {
        return $this->hasMany(UserRate::class);
    }
}
