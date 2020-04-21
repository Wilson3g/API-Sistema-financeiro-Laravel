<?php

namespace App\Repositories;
use App\Tag;
use App\Repositories\TagsRepositoryInterface;

class TagsRepositoryEloquent implements TagsRepositoryInterface {
    
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function all()
    {
        return $this->tag->orderby('id', 'desc')->get();
    }

    public function getTag($id)
    {
        return $this->tag->findOrFail($id);
    }

    public function create($data) 
    {
        return $this->tag->create($data);
    }

    public function updateTag($id, $data)
    {
        $tag = $this->tag->findOrFail($id);
        return $tag->update($data);
    }

    public function deleteTag($id)
    {
        $tag = $this->tag->findOrFail($id); 
        $tag->registro()->detach(); 
        return $tag->delete($id); 
    }
}