<?php

namespace App\Services;

use App\Http\Requests\TagRequest;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Repositories\TagsRepositoryInterface;

class TagsService
{
    public function __construct(TagsRepositoryInterface $tagsRepositoryInterface)
    {
        $this->tagsRepositoryInterface = $tagsRepositoryInterface;
    }

    public function index()
    {
        $tag = $this->tagsRepositoryInterface->all();

        return response()->json([
            'message' => 'Tags!',
            'success' => true,
            'data'=>$tag
        ], Response::HTTP_OK);
    }

    public function store(TagRequest $request)
    {
        $data = $request->all();

        try{
            $tag = $this->tagsRepositoryInterface->create($data);

            return response()->json([
                'message' => 'Tag criada com sucesso!',
                'success' => true
            ], Response::HTTP_OK);

        }catch(\Exception $e){
            return response()->json([
                'erro: ' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    { 
        $tag = $this->tagsRepositoryInterface->getTag($id);

        return response()->json([
            'message' => 'Tag encontrada!',
            'success' => true,
            'data' => $tag
        ], Response::HTTP_OK);
    }

    public function update(TagRequest $request, $id)
    {
        // if($this->tag->where('id', $id)->exists() == false)
        //     return response()->json([
        //         'message' => 'Tag não encontrada',
        //         'success' => false
        //     ], Response::HTTP_NOT_FOUND);

        $data = $request->all();
        $tag = $this->tagsRepositoryInterface->updateTag($id, $data);

        return response()->json([
            'message'=> 'Tag atualizada com sucesso!'
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $tag = $this->tagsRepositoryInterface->deleteTag($id);

        return response()->json([
            'message'=> 'Tag deletada com sucesso!'
        ], Response::HTTP_OK);
    }
}
