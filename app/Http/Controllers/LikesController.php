<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Like;
use App\Models\HostedImage;

class LikesController
{
    public function add_like(HostedImage $hostedImage)
    {
        // firstOrCreate - https://laravel.com/docs/12.x/eloquent
        // The firstOrCreate method will attempt to locate a database record using the given column / value pairs. 
        // If the model cannot be found in the database, 
        // a record will be inserted with the attributes resulting from merging the first array argument with the optional second array argument.

        Like::firstOrCreate([
            'user_id' => auth()->id(),
            'image_id' => $hostedImage->id
        ]);

        return back();
    }

    public function remove_like(HostedImage $hostedImage)
    {
        $like = $hostedImage->likes()
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
        }

        return back();
    }
}
