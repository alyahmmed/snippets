<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostImage;

class PostController extends Controller
{
    public function index()
    {
        return Post::paginate(5);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function images(Post $post)
    {
        return $post->images;
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->body =$request->get('body');
        $post->save();

        $this->saveImages($post, $request);

        return response()->json($post, 201);
    }

    public function update(Request $request, Post $post)
    {
        $post->body =$request->get('body');
        $post->save();

        $this->saveImages($post, $request);

        return response()->json($post, 200);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }

    private function saveImages($post, $request)
    {
        if ($request->hasFile('images')) {
            PostImage::where('post_id', $post->id)->delete();
            $images = $request->file('images');
            $upload_limit = count($images) < 3 ? count($images) : 3;
            for ($i=0; $i < $upload_limit; $i++) {
                $image = new PostImage;
                $image->post_id = $post->id;
                $image->filename = $images[$i]->getClientOriginalName();
                $image->save();

                $images[$i]->move('uploads',
                    $images[$i]->getClientOriginalName());
            }
        }
    }
}
