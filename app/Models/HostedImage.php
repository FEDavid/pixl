<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import User.php
use App\Models\User;

class HostedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'path',
        'size',
        'file_type',
    ];

    // Creating relationship between user and hostedimage - belongsTo as image only belongs to one user..
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Creating relationship for likes
    public function likes()
    {
        return $this->hasMany(Like::class, 'image_id');
    }

}