<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;

interface TagRepositoryInterface {
    public function findAll();
    public function findAllWithPaginate(string $name);
    public function save(array $tagData);
    public function update(array $newTagData, Tag $oldTagData);
    public function destroy(int $id);
}
