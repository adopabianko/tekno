<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Redis;

class TagRepository implements TagRepositoryInterface {
    public function findAll() {
        return Tag::where('status', 1)->orderBy('id','desc')->get();
    }

    public function findAllWithPaginate(string $name = null) {
        return Tag::when($name, function($q) use ($name) {
            return $q->where('name', 'like', "%{$name}%");
        })
        ->where('status', 1)->orderBy('id','desc')->paginate(10);
    }

    public function save(array $tag) {
        Redis::del("tekno_cache:tags");

        $tag['slug'] = str_replace(' ', '_', strtolower($tag['name']));
        $tag = new Tag($tag);

        return $tag->save();
    }

    public function update(array $newTagData, Tag $oldTagData) {
        Redis::del("tekno_cache:tags");

        return $oldTagData->update($newTagData);
    }

    public function destroy(int $id) {
        Redis::del("tekno_cache:tags");

        return Tag::where('id', $id)->update(['status' => 0]);
    }
}
