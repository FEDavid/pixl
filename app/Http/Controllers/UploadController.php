<?php

namespace App\Http\Controllers;

use App\Models\HostedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    // Custom function Dashboard to display only user's images
    public function dashboard()
    {
        $hostedImages = auth()->user()->hostedImages;
        return view('dashboard', ['hostedImages' => $hostedImages]);
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
        $request->validate([
            // Updated to now accept an array, and then validating that images are inside that array.
            'hostedImage' => ['required', 'array'],
            'hostedImage.*' => ['image'], // add 'max:5120' if you want size limit back
        ]);

        // // Testing as image not saving when uploading on AWS version
        // $files = $request->file('hostedImage');

        // dd(
        //     $files,                          // the whole array
        //     array_map(fn($f) => $f->isValid(), $files), // validity for each file
        //     array_map(fn($f) => $f->getError(), $files),
        //     ini_get('upload_max_filesize'),
        //     ini_get('post_max_size')
        // );

        // $file = $request->file('hostedImage');

        // $hostedImage = new HostedImage();
        // $hostedImage->file_type = $file->getMimeType();
        // $hostedImage->file_name = $file->getClientOriginalName();
        // $hostedImage->file_renamed = $file->getClientOriginalName();
        // $hostedImage->path = $file->store('hosted_images', 'public');
        // $hostedImage->file_size = $file->getSize();
        // $hostedImage->user_id = auth()->id();

        // $hostedImage->save();

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

        // For returning preview, will fix later
        // return view('hosted_images.create', [
        //     'id'        => $hostedImage->id,
        //     'path'      => $hostedImage->path,
        //     'file_name' => $hostedImage->file_name,
        //     'file_type' => $hostedImage->file_type,
        //     'file_size' => $hostedImage->file_size,
        //     'user_id'   => $hostedImage->user_id,
        // ]);

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
