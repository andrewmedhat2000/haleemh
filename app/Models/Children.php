<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Children extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $table='childrens';
   protected $fillable = [
    'name', 'nationality', 'hobby', 'image','date_of_birth', 'parent_id', 'is_diseased','disease','gender','note','age'
        ];

        protected $appends = [
            'image_url',
        ];
        public $upload_distination = '/uploads/images/childrens/';

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

     public function parents()
     {
         return $this->belongsTo(Parents::class);
     }
     public function order()
     {
         return $this->belongsToMany(Order_Children::class, 'order_children', 'child_id', 'order_id');
     }
     public function orders()
     {
        return $this->belongsToMany(Order::class, 'order_children', 'children_id', 'order_id');
     }


}
