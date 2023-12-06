<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Functions\Helper;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Query\Builder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['toSearch'])) {
            $posts = Post::where('title', 'LIKE', '%' . $_GET['toSearch'] . '%')->paginate(10);
        } else {
            $posts = Post::orderBy('id', 'desc')->paginate(20);
        }

        $direction = 'desc';

        $toSearch = '';
        return view('admin.posts.index', compact('posts', 'direction', 'toSearch'));
    }

    public function orderBy($direction, $column)
    {
        $direction = $direction == 'desc' ? 'asc' : 'desc';
        $posts = Post::orderBy($column, $direction)->paginate(20);
        $toSearch = '';
        return view('admin.posts.index', compact('posts', 'direction', 'toSearch'));

    }

    public function noTags(){

        $posts = Post::whereNotIn('id', function (Builder $query) {
            $query->select('post_id')->from('post_tag');
        })->paginate(20);
        $direction = 'desc';
        return view('admin.posts.index', compact('posts', 'direction'));
    }

    public function search(Request $request)
    {
        $toSearch = $request->toSearch;
        $posts = Post::where('title', 'LIKE', '%' . $toSearch . '%')->paginate(20);
        $direction = 'desc';
        return view('admin.posts.index', compact('posts', 'toSearch', 'direction'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Inserimento nuovo post';
        $method = 'POST';
        $route = route('admin.posts.store');
        $post = null;
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create-edit', compact('title', 'method', 'route', 'post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $form_data = $request->all();
        $form_data['slug'] = Helper::generateSlug($form_data['title'], Post::class);
        $form_data['date'] = date('Y-m-d');

        if(array_key_exists('image', $form_data)) {

            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            $form_data['image'] = Storage::put('uploads', $form_data['image']);



        }

        $new_post = Post::create($form_data);

        if(array_key_exists('tags', $form_data)) {
            $new_post->tags()->attach($form_data['tags']);
        }

        return redirect()->route('admin.posts.show', $new_post);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = 'Modifica post';
        $method = 'PUT';
        $route = route('admin.posts.update', $post);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create-edit', compact('title','method', 'route', 'post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $form_data = $request->all();
        if($form_data['title']!= $post->title){
            $form_data['slug'] = Helper::generateSlug($form_data['title'], Post::class);
        }else{
            $form_data['slug'] = $post->slug;
        }

        if(array_key_exists('image', $form_data)){
            if($post->image){
                Storage::disk('public')->delete($post->image);
            }

            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            $form_data['image'] = Storage::put('uploads', $form_data['image']);
        }

        $form_data['date'] = date('Y-m-d');

        $post->update($form_data);

        if(array_key_exists('tags', $form_data)) {
            $post->tags()->sync($form_data['tags']);
        }else{
            $post->tags()->detach();
        }
        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if($post->image){
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Il post è stato eliminato correttamente');


    }
}
