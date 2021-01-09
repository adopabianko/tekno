<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostCategoryInterface;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Redis;

class PostCategoryRepository implements PostCategoryInterface {

    public function findAll() {
        return PostCategory::where('status', 1)->orderBy('id','desc')->get();
    }

    public function findAllWithPaginate(string $name = null) {
        return PostCategory::with('parentCategory')
            ->when($name, function($q) use ($name) {
                return $q->where('name', 'like', "%{$name}%");
            })
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function save(array $postCategoryData) {
        Redis::del("tekno_cache:post:categories");

        $postCategoryData['slug'] = str_replace(' ', '-', strtolower($postCategoryData['name']));
        $postCategory = new PostCategory($postCategoryData);

        return $postCategory->save();
    }

    public function update(array $newPostCategoryData, PostCategory $oldPostCategoryData) {
        Redis::del("tekno_cache:post:categories");

        $newPostCategoryData['slug'] = str_replace(' ', '-', strtolower($newPostCategoryData['name']));

        return $oldPostCategoryData->update($newPostCategoryData);
    }

    public function destroy(int $id) {
        Redis::del("tekno_cache:post:categories");

        return PostCategory::where('id', $id)->update(['status' => 0]);
    }
}
