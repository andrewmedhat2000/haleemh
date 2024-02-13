<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImages extends Model
{
    protected $table = 'room_images';

    protected $fillable = ['room_id','image_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
