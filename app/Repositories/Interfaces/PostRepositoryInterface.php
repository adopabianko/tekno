<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface {
    public function datatables();
    public function save($PostCategoryData);
    public function update($reqParam, $PostCategoryData);
    public function destroy($id);
}