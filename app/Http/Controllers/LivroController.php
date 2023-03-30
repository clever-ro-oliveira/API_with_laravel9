<?php

namespace App\Http\Controllers;

use App\Http\Resources\LivroResource;
use App\Http\Resources\LivrosCollection;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new LivrosCollection(Livro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $livro = Livro::create($request->all());
        if ($livro) {
            if ($request->capa) {
                $path = $request->capa->store('capa_livro', 'public');
                $livro->capa = $path;
                $livro->save();
            }
            return response()->json([
                'message' => 'Livro cadastrado com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o livro!'
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $livro
     * @return \Illuminate\Http\Response
     */
    public function show($livro)
    {
        $getLivro = Livro::with('testamento', 'versiculos', 'versao')->find($livro);
        if ($getLivro) {
            if (isset($getLivro->capa)) {
                $getLivro->capa = Storage::disk('public')->url($getLivro->capa);
            }

            return response()->json(new LivroResource($getLivro), 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }

        return response()->json([
            'message' => 'Livro não encontrado!'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $livro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $livro)
    {
        $path = $request->capa->store('capa_livro', 'public');

        $getLivro = Livro::find($livro);
        if ($getLivro) {
            $getLivro->capa = $path;

            if ($getLivro->save()) {
                return $getLivro;
            }

            return response()->json([
                'message' => 'Erro ao atualizar o livro!'
            ], 404);
        }

        return response()->json([
            'message' => 'Erro ao atualizar o livro!'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $livro
     * @return \Illuminate\Http\Response
     */
    public function destroy($livro)
    {
        if (Livro::destroy($livro)) {
            return response()->json([
                'message' => 'Livro deletado com sucesso.'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o livro!'
        ], 404);
    }
}
