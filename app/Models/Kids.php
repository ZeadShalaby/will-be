<?php

namespace App\Models;

use App\Models\User;
use App\Models\Media;
use App\Models\Tests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kids extends Model
{
    use HasFactory;








    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function tests()
    {
        return $this->hasMany(Tests::class , 'kid_id');
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
