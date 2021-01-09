<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCategoryRequest;
use App\Repositories\PostCategoryRepository;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    protected $postCategoryRepository;

    public function __construct(PostCategoryRepository $postCategoryRepository) {
        $this->postCategoryRepository = $postCategoryRepository;
    }

    public function index(Request $request) {
        $name = $request->name;

        $categories = $this->postCategoryRepository->findAllWithPaginate($name);

        return view('post-category.index', compact('categories'));
    }

    public function create() {
        $parent = $this->postCategoryRepository->findAll();

        return view('post-category.create', compact('parent'));
    }

    public function store(PostCategoryRequest $request) {
        $save = $this->postCategoryRepository->save($request->all());

        if ($save) {
            \Session::flash("alert-success", "Category sucessfully saved");
        } else {
            \Session::flash("alert-danger", "Category unsucessfully saved");
        }

        return redirect()->route('post-category');
    }

    public function edit(PostCategory $category) {
        $parent = $this->postCategoryRepository->findAll();

        return view('post-category.edit', compact('category', 'parent'));
    }

    public function update(PostCategoryRequest $request, PostCategory $category) {
        $update = $this->postCategoryRepository->update($request->all(), $category);

        if ($update) {
            \Session::flash("alert-success", "Category sucessfully updated");
        } else {
            \Session::flash("alert-danger", "Category unsucessfully updated");
        }

        return redirect()->route('post-category');
    }

    public function destroy(PostCategory $category) {
        $destroy = $this->postCategoryRepository->destroy($category->id);

        if (!$destroy) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category unsuccessfully destroyed',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully destroyed',
        ]);
    }
}
