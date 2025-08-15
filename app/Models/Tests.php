<?php

namespace App\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tests extends Model
{
    use HasFactory;




    public function kids()
    {
        return $this->belongsTo(Kids::class, 'kid_id');
    }

    public function media_one()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
