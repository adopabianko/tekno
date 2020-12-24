<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Yajra\Datatables\Datatables;

class PostRepository implements PostRepositoryInterface {
    public function datatables() {
        return Datatables::of(Post::with('Category')->where('status', '!=', 0)->orderBy('id','desc')->get())
            ->editColumn('actions', function($col) {
                $actions = '';

                if (\Laratrust::isAbleTo('post-edit-data')) {
                    $actions .= '
                        <a href="'.route('post.edit', ['post' => $col->id]).'" class="btn btn-xs bg-gradient-info" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                    ';
                }

                if (\Laratrust::isAbleTo('post-destroy-data')) {
                    $actions .= '
                        <a href="javascript:void(0)" class="btn btn-xs bg-gradient-danger" onclick="Delete('.$col->id.','."'".$col->name."'".')" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                        </a>
                    ';
                }

                return $actions;
            })
            ->editColumn('category', function($col) {
                return $col->Category->name;
            })
            ->editColumn('status', function($col) {
                $status = '';

                if ($col->status == 1) {
                    $status = 'Draft';
                } elseif ($col->status == 2) {
                    $status = 'Publish';
                }

                return $status;
            })
            ->rawColumns(['category',  'status', 'actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save($post) {
        $file = $post->file('cover');
        $storageName = \Storage::disk('local')->put('public/posts', $file);

        $requestAll = $post->all();
        $requestAll['cover'] = basename($storageName);
        $requestAll['slug'] = str_replace(' ', '_', strtolower($requestAll['title']));

        $post = new Post($requestAll);
        $post->save();

        return $post->id;
    }

    public function update($reqParam, $post) {
        $dataUpdate = $reqParam->all();

        if ($reqParam->file('cover')) {
            \Storage::disk('local')->delete("public/posts/{$post->cover}");

            $file = $reqParam->file('cover');
            $storageName = \Storage::disk('local')->put('public/posts', $file);

            $dataUpdate['cover'] = basename($storageName);
        } else {
            unset($dataUpdate['cover']);
        }

        $dataUpdate['slug'] = str_replace(' ', '_', strtolower($dataUpdate['title']));

        return $post->update($dataUpdate);
    }

    public function destroy($id) {
        return Post::where('id', $id)->update(['status' => 0]);
    }
}
