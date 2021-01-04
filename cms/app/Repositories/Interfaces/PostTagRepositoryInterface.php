<?php

namespace App\Repositories\Interfaces;

interface PostTagRepositoryInterface {
    public function save($postId, $tags);
    public function findByPostId($postId);
    public function update($postId, $tags);
}
