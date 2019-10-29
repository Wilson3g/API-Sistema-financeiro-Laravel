<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TagRequest;
use App\Tag;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    } 

    public function index()
    {
        $tag = $this->tag->orderby('id', 'desc')->get();

        return response()->json(['data'=>$tag], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *///Definição do arquivo de validação
    public function store(TagRequest $request)
    {
        $data = $request->all();

        try{
            
            $tag = $this->tag->create($data);

            return response()->json([
                'data'=> [
                    'msg'=> 'Tag registrada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $tag = $this->tag->findOrFail($id);

        return response()->json([
            'data'=> [
                'msg'=> 'Tag encontrada!',
                'data'=> $tag
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $data = $request->all();
            
        $tag = $this->tag->findOrFail($id);
        $tag->update($data);

        return response()->json([
            'data'=> [
                'msg'=> 'Tag atualizada com sucesso!'
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $tag = $this->tag->findOrFail($id); 
            $tag->registro()->detach(); 
            $tag->delete($id); 

            return response()->json([
                'data'=> [
                    'msg'=> 'Tag deletada com sucesso!'
                ]
            ], 200);

    }

    public function tags($id)
    {
        $tags = $this->tag->findOrFail($id);

        return response()->json([
            'data' => $tags->registro 
        ], 200);
        
    }
}
