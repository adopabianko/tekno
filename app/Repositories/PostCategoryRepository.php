<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostCategoryInterface;
use App\Models\PostCategory;
use Yajra\Datatables\Datatables;

class PostCategoryRepository implements PostCategoryInterface {

    public function getAll() {
        return PostCategory::all();
    }

    public function datatables() {
        return Datatables::of(PostCategory::with('parentCategory')->where('status', 1)->orderBy('id','desc')->get())
            ->editColumn('actions', function($col) {
                $actions = '';

                if (\Laratrust::isAbleTo('post-category-edit-data')) {
                    $actions .= '
                        <a href="'.route('post-category.edit', ['category' => $col->id]).'" class="btn btn-xs bg-gradient-info" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                    ';
                }

                if (\Laratrust::isAbleTo('post-category-destroy-data')) {
                    $actions .= '
                        <a href="javascript:void(0)" class="btn btn-xs bg-gradient-danger" onclick="Delete('.$col->id.','."'".$col->name."'".')" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                        </a>
                    ';
                }

                return $actions;
            })
            ->editColumn('parentCategory', function($col) {
                return isset($col->parentCategory->name) ? $col->parentCategory->name : '';
            })
            ->rawColumns(['parentCategory', 'actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save($postCategoryData) {
        $postCategoryData['slug'] = str_replace(' ', '_', strtolower($postCategoryData['name']));
        $postCategory = new PostCategory($postCategoryData);

        return $postCategory->save();
    }

    public function update($reqParam, $postCategoryData) {
        $dataUpdate = $reqParam->all();
        $dataUpdate['slug'] = str_replace(' ', '_', strtolower($dataUpdate['name']));

        return $postCategoryData->update($dataUpdate);
    }

    public function destroy($id) {
        return PostCategory::where('id', $id)->update(['status' => 0]);
    }
}
