<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestamentoResource;
use App\Http\Resources\TestamentosCollection;
use App\Models\Testamento;
use Illuminate\Http\Request;

class TestamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TestamentosCollection(Testamento::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Testamento::create($request->all())) {
            return response()->json([
                'message' => 'Testamento cadastrado com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o testamento!'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $testamento
     * @return \Illuminate\Http\Response
     */
    public function show($testamento)
    {
        $getTestamento = Testamento::with('livros')->find($testamento);
        if ($getTestamento) {
            return new TestamentoResource($getTestamento);
        }

        return response()->json([
            'message' => 'Testamento não encontrado!'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $testamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $testamento)
    {
        $getTestamento = Testamento::find($testamento);
        if ($getTestamento) {
            $getTestamento->update($request->all());
            return $getTestamento;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o testamento!'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $testamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($testamento)
    {
        if (Testamento::destroy($testamento)) {
            return response()->json([
                'message' => 'Testamento deletado com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o testamento!'
        ], 404);
    }
}
