<?php

namespace App\Repositories\Interfaces;

use App\Models\PostCategory;

interface PostCategoryInterface {
    public function findAll();
    public function findAllWithPaginate(string $name);
    public function save(array $PostCategoryData);
    public function update(array $newPostCategoryData, PostCategory $oldPostCategoryData);
    public function destroy(int $id);
}
