<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class ImageController extends Controller
{
    /**
     * Display the specified image.
     *
     * @param  string  $imageName
     * @return \Illuminate\Http\Response
     */
    public function show($imageName)
    {
        // Construct the full path to the image within the storage directory
        // $path = storage_path("app/public/images/{$imageName}");

        $path = storage_path("app/public/images/{$imageName}".".jpg");
        if (Storage::disk('public')->exists("images/{$imageName}")) {
            $path = storage_path("app/public/images/{$imageName}".".jpg");
        }
        else {
            $path = storage_path("app/public/images/default.jpg");
        }

        // Return the image as a response
        return response()->file($path);
    }
    public function view($img_path)
    {
        $post = Post::find($post_id);
        $path = 'images/' . $post->img_path
        // \Debugbar::enable();
        Debugbar::info($post);
        if (Storage::disk('public')->exists($path)) {
            return response()->file($path);
        }
        else {
            return response()->file($path);
    }
    }
}
