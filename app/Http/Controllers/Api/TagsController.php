<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TagRequest;
use App\Services\TagsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TagsController extends Controller
{
    public function __construct(TagsService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        return $this->tagService->index();
    }

    public function store(TagRequest $request)
    {
        return $this->tagService->store($request);
    }

    public function show($id)
    {
        return $this->tagService->show($id);
    }

    public function update(TagRequest $request, $id)
    {
        return $this->tagService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->tagService->destroy($id);
    }

    public function tags($id)
    {
        return $this->tagService->tags($id);
    }
}
