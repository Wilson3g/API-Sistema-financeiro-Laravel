<?php

namespace App\Repositories;

interface TagsRepositoryInterface {
    public function all();
    public function getTag($id);
    public function create($data);
    public function updateTag($id, $request);
    public function deleteTag($id);
}