<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=> ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM posts');
        return view('posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=> 'required',
            'body'=> 'required',
            'cover_image' => 'image|nullable|max:1999;'
        ]);
        //handle the file upload
        $fileNameToStore = $this->storeImage($request, 'cover_image', 'upload');

        $post = new Post();

        $post->title = request('title');
        $post->body = request('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;

        $post->save();

        return redirect('/posts')->with('success', 'Post created') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('posts.show')->with('post', Post::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=> 'required',
            'body'=> 'required',
            'cover_image' => 'image|nullable|max:1999;'
        ]);
        //handle the file upload
        $fileNameToStore = $this->storeImage($request, 'cover_image');

        $post = Post::findOrFail($id);
        $post->title = request('title');
        $post->body = request('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }

        $post->save();

        return redirect('/posts')->with('success', 'Post updated') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        if($post->cover_image !== 'noimage.png'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }

    /**
     * Handle uploading of image file
     *
     * @param Request $request
     * @param string $attribute
     * @return string
     *
     */
    private function storeImage(Request $request, string $attribute, string $operation = ''){
        $fileNameToStore='';
        if($request->hasFile($attribute)){
            //get filename with extensions
            $filenameWithExt = $request->file($attribute)->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt)['filename'];
            //get the extension
            $extension = pathinfo($filenameWithExt)['extension'];
            //filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file($attribute)->storeAs('public/'.$attribute.'s', $fileNameToStore);
        }
        if ($operation==='upload'){
            $fileNameToStore = 'noimage.png';
        }
        return $fileNameToStore;
    }
}
