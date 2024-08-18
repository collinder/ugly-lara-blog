<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('status','Опубликованный')->orderBy('created_at', 'desc')
            ->simplePaginate(12);
        return view('auth.view')->with('posts', $posts);
    }

    public function show(Post $profile)
    {
       if ($profile->status === 'Черновик') {
                  abort(404);
       }

        return view('profile.guest')->with('post', $profile);

    }


    /**
     * Display the specified resource.
     */


}
