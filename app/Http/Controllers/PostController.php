<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Repositories\PostCategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\PostTagRepository;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    private $postRepository;
    private $postCategoryRepository;
    private $tagRepository;
    private $postTagRepository;

    public function __construct(
        PostRepository $postRepository,
        PostCategoryRepository $postCategoryRepository,
        TagRepository $tagRepository,
        PostTagRepository $postTagRepository
    ) {
        $this->postRepository = $postRepository;
        $this->postCategoryRepository = $postCategoryRepository;
        $this->tagRepository = $tagRepository;
        $this->postTagRepository = $postTagRepository;
    }

    public function index() {
        return view('post.index');
    }

    public function datatables() {
        return $this->postRepository->datatables();
    }

    public function create() {
        $categories = $this->postCategoryRepository->getAll();
        $tags = $this->tagRepository->getAll();

        return view('post.create', compact('categories', 'tags'));
    }

    public function store(PostRequest $request) {
        \DB::beginTransaction();

        try {
            $postId = $this->postRepository->save($request);
            if ($request->tags)
                $this->postTagRepository->save($postId, $request->tags);

            \DB::commit();

            \Session::flash("alert-success", "Post sucessfully saved");
        } catch (\Exception $e) {
            \DB::rollback();

            \Session::flash("alert-danger", "Post unsucessfully saved");
        }

        return redirect()->route('post');
    }

	public function edit(Post $post) {
        $categories = $this->postCategoryRepository->getAll();
        $tags = $this->tagRepository->getAll();
        $postTag = $this->postTagRepository->findByPostId($post->id);

        $tagData = [];
        foreach($postTag as $item) {
            $tagData[] = $item->tag_id;
        }

        return view('post.edit', compact('post', 'categories', 'tags', 'tagData'));
    }

    public function update(PostRequest $request, Post $post) {
        \DB::beginTransaction();

        try {
            $this->postRepository->update($request, $post);

            if ($request->tags)
                $this->postTagRepository->update($post->id, $request->tags);

            \DB::commit();

            \Session::flash("alert-success", "Post sucessfully updated");

        } catch (\Exception $e) {
            \DB::rollback();

            \Session::flash("alert-danger", "Post unsucessfully updated");

        }

       return redirect()->route('post');
    }

    public function destroy(Post $post) {
        $destroy = $this->postRepository->destroy($post->id);

        if (!$destroy) {
            return response()->json([
               'status' => 'error',
               'message' => 'Post unsuccessfully destroyed',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Post successfully destroyed',
        ]);
    }
}
