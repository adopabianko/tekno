<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;

class PostRepository implements PostRepositoryInterface {
    public function findAllWithPaginate(string $title = null, string $category = null)
    {
        return Post::with('Category')
            ->when($title, function($q) use ($title){
                return $q->where('title', 'like', "%{$title}%");
            })
            ->when($category && $category !== 'all', function($q) use ($category) {
                $q->whereHas('Category', function($q) use ($category) {
                    return $q->where('slug', $category);
                });
            })
            ->where('status', '!=',0)
            ->orderBy('id', 'desc')->paginate(10);
    }

    public function save(array $postData, UploadedFile $cover) {
        Redis::del('tekno_cache:posts*');

        $storageName = \Storage::disk('local')->put('public/posts', $cover);

        $postData['cover'] = basename($storageName);
        $postData['slug'] = str_replace(' ', '-', strtolower($postData['title']));

        $postSave = new Post($postData);
        $postSave->save();

        return $postSave->id;
    }

    public function update(array $newPostData, Post $oldPostData, UploadedFile $cover = null) {
        $category = PostCategory::select('slug')->where('id', $newPostData['category_id'])->first();
        Redis::del('tekno_cache:posts');
        Redis::del('tekno_cache:posts:'.$category->slug);

        if ($cover) {
            \Storage::disk('local')->delete("public/posts/{$oldPostData->cover}");

            $storageName = \Storage::disk('local')->put('public/posts', $cover);

            $newPostData['cover'] = basename($storageName);
        } else {
            unset($newPostData['cover']);
        }

        $newPostData['slug'] = str_replace(' ', '-', strtolower($newPostData['title']));

        return $oldPostData->update($newPostData);
    }

    public function destroy(int $id) {
        $post = Post::find($id);

        $category = PostCategory::select('slug')->where('id', $post->category_id)->first();
        Redis::del('tekno_cache:posts');
        Redis::del('tekno_cache:posts:'.$category->slug);

        $post->status = 0;
        return $post->save();
    }
}
