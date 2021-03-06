<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use Intervention\Image\Facades\Image;

class BlogController extends BackendController
{
    protected $limit = 6;
    protected $uploadPath;

    public function __construct() {

        parent::__construct();
        $this->uploadPath = public_path(config('cms.image.directory'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts     = Post::with('category', 'author')
                   ->latest()
                   ->paginate($this->limit);

        $postCount = Post::count();

        return view("backend.blog.index", compact('posts', 'postCount'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('backend.blog.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PostRequest $request) {

        $data = $this->handleRequest($request);

        $request
            ->user()
            ->posts()
            ->create($data);

        return redirect('/backend/blog')
            ->with('message', 'Your post was created successfully!');
    }

    private function handleRequest($request) {

        $data = $request->all();

        if ($request->hasFile('image'))
        {
            $width = config('cms.image.thumbnail.width');
            $height = config('cms.image.thumbnail.height');
            $image       = $request->file('image');
            $fileName    = $image->getClientOriginalName();
            $destination = $this->uploadPath;

            $successUploaded =  $image->move($destination, $fileName);

            if ($successUploaded) {

                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $fileName);

                Image::make($destination . '/' . $fileName)
                                         ->resize($width, $height)
                                         ->save($destination . '/' . $thumbnail);
            }

            $data['image'] = $fileName;
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $post = Post::findOrFail($id);
        return view("backend.blog.edit", compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PostRequest $request, $id)
    {
        $post     = Post::findOrFail($id);
        $oldImage = $post->image;
        $data     = $this->handleRequest($request);
        $post->update($data);

        // if ($oldImage !== $post->image) {
        //     $this->removeImage($oldImage);
        // }
        return redirect('/backend/blog')->with('message', 'Your post was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect('/backend/blog')->with('message', 'Your post was deleted succesfully!');
    }
}
