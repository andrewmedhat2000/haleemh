<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $table='orders';
   protected $fillable = [
    'date','time','days','long','lat','hours','parent_id','setter_id','driver_id','status','order_activity'
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



     public function childrens()
     {
         return $this->belongsToMany(OrderChildren::class, 'order_children', 'order_id', 'children_id');
     }
     public function children()
     {
        return $this->belongsToMany(Children::class, 'order_children', 'order_id', 'children_id');
     }
     public function setter()
     {
         return $this->belongsTo(Setter::class);
     }
     public function parent()
     {
         return $this->belongsTo(Parents::class);
     }
     public function driver()
     {
         return $this->belongsTo(Driver::class);
     }


}
