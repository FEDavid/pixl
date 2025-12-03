<?php

namespace App\Http\Controllers;

// Import models
use App\Models\HostedImage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    // Custom function Dashboard to display only user's images
    public function profile()
    {
        $hostedImages = auth()->user()->hostedImages;
        return view('profile', ['hostedImages' => $hostedImages]);
    }

    public function index()
    {
        $hostedImages = HostedImage::all();
        return view('hosted_images.index', ['hostedImages' => $hostedImages]);
    }

    public function create()
    {
        return view('hosted_images.create');
    }

    public function store(Request $request)
    {
        // Image validation before upload

        // Updated to now accept an array, and then validating that images are inside that array.
        // Validation added to confirm multiple things -
        // - required, literally that the item exists and is valid, so not null meaning the array cannot be empty and must have at least 1 image
        // - array, that itself is an array being provided
        // - max:3, that a maximum of 3 images can be uploaded at a time

        // -'image', that the item being uploaded is in fact an image
        // -'mimes', that the file type being provided matches the ones provided
        // -'max:20480', maximum file size of 20MB.

        // Requesting the route /phpinfo-test will confirm we have increased the individual file and POST size on the PHP config
        // Allowing for larger files to be uploaded, at a maximum of 25M per POST, but users can upload 1 image at 20MB for example.

        // Added keyword multiple on input for upload to alow multiple uploads.
        $request->validate([
            'hostedImage' => ['required', 'array', 'max:3'],
            'hostedImage.*' => ['image', 'mimes:jpg,jpeg,png', 'max:20480'],
        ]);

        // Instead of singular save above, looping through array and saving each image
        foreach ($request->file('hostedImage') as $file) {
            $hostedImage = new HostedImage();
            $hostedImage->file_type = $file->getMimeType();
            $hostedImage->file_name = $file->getClientOriginalName();
            $hostedImage->file_renamed = $file->getClientOriginalName();
            $hostedImage->path = $file->store('hosted_images', 'public');
            $hostedImage->file_size = $file->getSize();
            $hostedImage->user_id = auth()->id();
            $hostedImage->save();
        }

        // For redirecting to uploads
        return redirect()->route('uploads.index')->with('success', 'Image(s) uploaded!');
    }

    

    // Slightly different function to one showcased in class, reason for this is because I am using public storage so image URLs can be shared
    public function show(HostedImage $hostedImage)
    {
        return view('hosted_images.show', [
            'hostedImage' => $hostedImage
        ]);
    }



    public function edit(HostedImage $hostedImage)
    {
        return view('uploads.edit', [
            'id'        => $hostedImage->id,
            'path'      => $hostedImage->path,
            'file_name' => $hostedImage->file_name,
            'file_type' => $hostedImage->file_type,
            'file_size' => $hostedImage->file_size,
            'user_id'   => $hostedImage->user_id,
        ]);
    }



    public function update(Request $request, HostedImage $hostedImage)
    {
        $request->validate([
            'file_renamed' => ['required', 'string', 'max:255'],
        ]);

        $hostedImage->file_renamed = $request->file_renamed;

        $hostedImage->save();

        return redirect()
            ->route('uploads.show', $hostedImage->id)
            ->with('success', 'Image name updated.');
    }




    public function destroy(HostedImage $hostedImage)
    {
        // Testing
        // $testvar = Storage::disk('public')->delete($hostedImage->path);
        // dd($testvar);
        // return back()->with([
        //     'operation' => 'deleted',
        //     'id'        => $hostedImage->id,
        // ]);

        // Confirmed it seems to be deleting images
        Storage::disk('public')->delete($hostedImage->path);
        $hostedImage->delete();
        return redirect()
            ->route('uploads.index')
            ->with('deleted', 'Image deleted');
    }
}

