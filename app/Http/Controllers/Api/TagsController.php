<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TagRequest;//importação do arquivo de validação
use App\Tag; // Importando o model Tag
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
        // mosta todos os dados em ordem decrescente
        $tag = $this->tag->orderby('id', 'desc')->get();

        return response()->json(['data'=>$tag], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        // Salva todos os requests em uma variavel
        $data = $request->all();

        // tratamento de erros
        try{
            
            // envia os dados do request para a tabela
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
        try{
            
            // realiza uma busca na tabela com o id informado
            $tag = $this->tag->findOrFail($id);

            return response()->json([
                'data'=> [
                    'msg'=> 'Tag encontrada!',
                    'data'=> $tag
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
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

        try{
            
            // realiza uma busca na tabela com o id informado
            $tag = $this->tag->findOrFail($id);
            // Realiza a atualização da tag pelo id informado
            $tag->update($data);

            return response()->json([
                'data'=> [
                    'msg'=> 'Tag atualizada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            // envia a variável com requests para a tabela
            $tag = $this->tag->findOrFail($id); 
            // destaca a tabela tags da tabela pivot
            $tag->registro()->detach(); 
            // deleta o registro pelo id
            $tag->delete($id); 

            return response()->json([
                'data'=> [
                    'msg'=> 'Tag deletada com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
    }

    public function tags($id)
    {
        try{

            $tags = $this->tag->findOrFail($id);

            return response()->json([
                //mostra a relação dos registros
                'data' => $tags->registro 
            ], 200);

        }catch(\Exception $e){
            return response()->json(['erro: ' => $e->getMessage()], 401);
        }
        
    }
}
