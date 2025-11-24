<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import User.php and HostedImage.php
use App\Models\User;
use App\Models\HostedImage;


class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hostedImage()
    {
        return $this->belongsTo(HostedImage::class, 'image_id');
    }
}