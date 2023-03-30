<?php

namespace App\Http\Controllers;

use App\Models\Versiculo;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index() {
        $versiculoDoDia = Versiculo::with('livro')->find(rand(1,31062));

        return response()->json($versiculoDoDia);
    }

    public function lerBiblia($versao, $livro = null, $capitulo = null, $versiculo = null) {
        $versiculos = Versiculo::whereHas('livro', function($query) use($versao, $livro) {
            $query->whereHas('versao', function($query) use($versao) {
                $query->where('abreviacao', $versao);
            });
            $query->when($livro, function($query) use($livro) {
                $query->where('abreviacao', $livro);
            });
        })->filters([
            'capitulo' => $capitulo,
            'versiculo' => $versiculo
        ])->get();

        return response()->json($versiculos);
    }
}
