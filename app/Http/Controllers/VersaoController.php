<?php

namespace App\Http\Controllers;

use App\Http\Resources\VersaoResource;
use App\Http\Resources\VersoesCollection;
use App\Models\Versao;
use Illuminate\Http\Request;

class VersaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new VersoesCollection(Versao::select('id', 'nome', 'abreviacao')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Versao::create($request->all())) {
            return response()->json([
                'message' => 'Versao cadastrada com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar a versao!'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $versao
     * @return \Illuminate\Http\Response
     */
    public function show($versao)
    {
        $getVersao = Versao::with('idioma', 'livros')->find($versao);
        if ($getVersao) {
            return new VersaoResource($getVersao);
        }

        return response()->json([
            'message' => 'Versao não encontrada!'
        ], 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $versao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $versao)
    {
        $getVersao = Versao::find($versao);
        if ($getVersao) {
            $getVersao->update($request->all());
            return $getVersao;
        }

        return response()->json([
            'message' => 'Erro ao atualizar a versao!'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $versao
     * @return \Illuminate\Http\Response
     */
    public function destroy($versao)
    {
        if (Versao::destroy($versao)) {
            return response()->json([
                'message' => 'Versao deletada com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar a versao!'
        ], 404);

    }
}
