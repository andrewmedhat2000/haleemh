<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem',
        'description',
        'setter_id',
        'parent_id',
    ];
    public function parents()
    {
        return $this->belongsTo(Parents::class);
    }
    public function setters()
    {
        return $this->belongsTo(Setter::class);
    }
}
