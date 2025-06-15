<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Exibe o álbum de fotos do aluno logado.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $studentWithPhotos = $user->student()->with('photos')->first();

        return Inertia::render('Album/Index', [
            'photos' => $studentWithPhotos ? $studentWithPhotos->photos : [],
        ]);
    }
}
