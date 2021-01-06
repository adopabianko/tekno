<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Redis;

class TagRepository implements TagRepositoryInterface {
    public function getAll() {
        return Tag::where('status', 1)->orderBy('id','desc')->get();
    }

    public function datatables() {
        return Datatables::of(Tag::where('status', 1)->orderBy('id','desc')->get())
            ->editColumn('actions', function($col) {
                $actions = '';

                if (\Laratrust::isAbleTo('tag-edit-data')) {
                    $actions .= '
                        <a href="'.route('tag.edit', ['tag' => $col->id]).'" class="btn btn-xs bg-gradient-info" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                    ';
                }

                if (\Laratrust::isAbleTo('tag-destroy-data')) {
                    $actions .= '
                        <a href="javascript:void(0)" class="btn btn-xs bg-gradient-danger" onclick="Delete('.$col->id.','."'".$col->name."'".')" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                        </a>
                    ';
                }

                return $actions;
            })
            ->editColumn('tag', function($col) {
                return isset($col->tag->name) ? $col->tag->name : '';
            })
            ->rawColumns(['tag', 'actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save($tag) {
        Redis::del("tekno_cache:tags");

        $tag['slug'] = str_replace(' ', '_', strtolower($tag['name']));
        $tag = new Tag($tag);

        return $tag->save();
    }

    public function update($reqParam, $tag) {
        Redis::del("tekno_cache:tags");
        
        $dataUpdate = $reqParam->all();
        $dataUpdate['slug'] = str_replace(' ', '_', strtolower($dataUpdate['name']));

        return $tag->update($dataUpdate);
    }

    public function destroy($id) {
        Redis::del("tekno_cache:tags");

        return Tag::where('id', $id)->update(['status' => 0]);
    }
}