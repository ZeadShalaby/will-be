<?php

namespace App\Models;

use App\Models\Kids;
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


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }


    public function media_one()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
