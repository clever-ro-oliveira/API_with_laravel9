<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdiomaResource;
use App\Models\Idioma;
use Illuminate\Http\Request;

class IdiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Idioma::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Idioma::create($request->all())) {
            return response()->json([
                'message' => 'Idioma cadastrado com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o idioma!'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idioma
     * @return \Illuminate\Http\Response
     */
    public function show($idioma)
    {
        $getIdioma = Idioma::with('versoes')->find($idioma);
        if ($getIdioma) {
            return new IdiomaResource($getIdioma);
        }

        return response()->json([
            'message' => 'Idioma não encontrado!'
        ], 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idioma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idioma)
    {
        $getIdioma = Idioma::find($idioma);
        if ($getIdioma) {
            $getIdioma->update($request->all());
            return $getIdioma;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o idioma!'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idioma
     * @return \Illuminate\Http\Response
     */
    public function destroy($idioma)
    {
        if (Idioma::destroy($idioma)) {
            return response()->json([
                'message' => 'Idioma deletado com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o idioma!'
        ], 404);

    }
}
