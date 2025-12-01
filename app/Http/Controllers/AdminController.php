<?php

namespace App\Http\Controllers;

// Import models
use App\Models\HostedImage;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Index to gather all images
    public function index()
    {
        // Pagination
        $hostedImages = HostedImage::paginate(4);
        $allUsers = User::all();

        // Return both to admin panel view
        return view('admin.panel', ['hostedImages' => $hostedImages], ['allUsers' => $allUsers]);
    }
}
