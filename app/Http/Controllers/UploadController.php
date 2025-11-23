<?php

namespace App\Http\Controllers;

use App\Models\HostedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
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
            // 'hostedImage' => ['required', 'image', 'max:5120'], for max sizing
            'hostedImage' => ['required', 'image'],
        ]);

        $file = $request->file('hostedImage');

        $hostedImage = new HostedImage();
        $hostedImage->file_type = $file->getMimeType();
        $hostedImage->file_name = $file->getClientOriginalName();
        $hostedImage->file_renamed = $file->getClientOriginalName();
        $hostedImage->path = $file->store('hosted_images', 'public');
        $hostedImage->file_size = $file->getSize();
        $hostedImage->user_id = auth()->id();

        $hostedImage->save();

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
        return redirect()->route('uploads.index')->with('success', 'Image uploaded!');
    }


    // Slightly different function to one showcased in class, reason for this is because I am using public storage so image URLs can be shared
    public function show(HostedImage $hostedImage)
    {
        return view('hosted_images.show', [
            'image' => $hostedImage
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
        Storage::disk('public')->delete($hostedImage->path);
        $hostedImage->delete();

        return back()->with([
            'operation' => 'deleted',
            'id'        => $hostedImage->id,
        ]);
    }
}
