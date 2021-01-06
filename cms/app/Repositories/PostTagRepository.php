<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Models\PostTag;
use App\Repositories\Interfaces\PostTagRepositoryInterface;

class PostTagRepository implements PostTagRepositoryInterface {

    public function save($postId, $tags)
    {
        Cache::forget('tags');

        $data = [];
        foreach ($tags as $item) {
            $data[] = [
                'post_id' => $postId,
                'tag_id' => $item,
                'created_at' => now(), 
                'updated_at' => now(), 
            ];
        }
        return PostTag::insert($data);
    }

    public function findByPostId($postId) {
        return PostTag::where('post_id', $postId)->get();
    }

    public function update($postId, $tags) {
        \DB::beginTransaction();

        try {
            Cache::forget('tags');
            
            PostTag::where('post_id', $postId)->delete();

            $data = [];
            foreach ($tags as $item) {
                $data[] = [
                    'post_id' => $postId,
                    'tag_id' => $item, 
                    'updated_at' => now(),
                ];
            }

            PostTag::insert($data);

            \DB::commit();

            return true;
        } catch (\Exception $e) {
            \DB::rollback();

            return false;
        }
    }
}
