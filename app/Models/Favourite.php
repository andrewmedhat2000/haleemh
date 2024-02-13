<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table='favorites';
    protected $fillable = ['setter_id', 'parent_id'];

    

    public function setter()
    {
        return $this->belongsTo(Setter::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }
}