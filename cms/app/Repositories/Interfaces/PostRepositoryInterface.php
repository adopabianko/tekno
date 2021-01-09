<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

interface PostRepositoryInterface {
    public function findAllWithPaginate(string $title, string $category);
    public function save(array $postData, UploadedFile $cover);
    public function update(array $newPostData, Post $oldPostData, UploadedFile $cover);
    public function destroy(int $id);
}
