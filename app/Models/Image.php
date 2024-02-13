<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Image extends Model
{
    //
    protected $table = 'images';

    protected $fillable = [
        'image'
    ];

    protected $appends = [
        'image_url',
    ];

    public $upload_distination = '/uploads/images/app/';

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

    /**
     * Relations
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_images', 'image_id', 'room_id')->withTimestamps();
    }

    public function roomImages()
    {
        return $this->hasOne(RoomImages::class);
    }

}
