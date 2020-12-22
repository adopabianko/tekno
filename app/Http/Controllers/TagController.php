<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TagRepository;
use App\Models\Tag;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    private $tagRepository;

    public function __construct(
        TagRepository $tagRepository
    ) {
        $this->tagRepository = $tagRepository;    
    }

    public function index() {
        return view('tag.index');
    }

    public function datatables() {
        return $this->tagRepository->datatables();
    }

    public function create() {
        return view('tag.create');
    }

    public function store(TagRequest $request) {
        $save = $this->tagRepository->save($request->all());

        if ($save) {
            \Session::flash("alert-success", "Tag sucessfully saved");
        } else {
            \Session::flash("alert-danger", "Tag unsucessfully saved");
        }

        return redirect()->route('tag');
    }

	public function edit(Tag $tag) {
        return view('tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag) {
       $update = $this->tagRepository->update($request, $tag);

       if ($update) {
           \Session::flash("alert-success", "Tag sucessfully updated");
       } else {
           \Session::flash("alert-danger", "Tag unsucessfully updated");
       }

       return redirect()->route('tag');
    }

    public function destroy(Tag $tag) {
        $destroy = $this->tagRepository->destroy($tag->id);

        if (!$destroy) {
            return response()->json([
               'status' => 'error',
               'message' => 'Tag unsuccessfully destroyed',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tag successfully destroyed',
        ]);
    }  
}
