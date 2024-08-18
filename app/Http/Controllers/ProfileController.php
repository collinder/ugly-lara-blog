<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Debugbar;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
           ->orderBy('created_at', 'desc')
           ->simplePaginate(12);
        // DebugBar::info($posts);
        // app('debugbar')->info('info message');

        return view('profile.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Общее', 'Программирование', "Общение"];

        $status = ['Опубликованный', 'Черновик'];

        return view('profile.create')
            ->with('categories', $categories)
            ->with('status', $status);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        if (!empty($request->file('image')))  {
            $image  =  $request->file('image');
            $destinationPath = 'images/';
            $profileImage = $request->name . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $validated = array_merge($validated, array('img_path' => "$profileImage"));
        }
        else {
            $placeholder = "default.jpg";
            $validated = array_merge($validated, array('img_path' => "$placeholder"));
        }

        Post::create($validated);
        return redirect('/profile')
            ->with('msg', config('message.msg.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $profile)
    {
        if (auth()->id() != $profile->user_id) {
            abort(404);
        }
        return view('profile.show')->with('post', $profile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $profile)
    {
        $this->authorize('view', $profile);

        $categories = ['Общее', 'Программирование', "Общение"];

        $status = ['Опубликованный', 'Черновик'];

        return view('profile.edit')
            ->with('status', $status)
            ->with('categories', $categories)
            ->with('post', $profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $profile)
    {
        $validated = $request->validated();
        $image=$request->image;
        if (!empty($request->file('image')))  {
            $image  =  $request->file('image');
            $destinationPath = 'images/';
            $profileImage = $request->name . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $validated = array_merge($validated, array('img_path' => "$profileImage"));
        }


        $profile->update($validated);
        return redirect('/profile')
            ->with('msg', config('message.msg.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $profile)
    {
        $profile->delete();

        return redirect('/profile')
            ->with('msg', config('message.msg.deleted'));
    }
}
