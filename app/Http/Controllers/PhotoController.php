<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iPhotoService;
use App\Models\Photo;
use App\Models\Student;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    private iPhotoService $service;

    public function __construct(iPhotoService $service)
    {
        $this->service = $service;
    }

    /**
     * Armazena uma nova foto para um aluno específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\RedirectResponse
     */
     public function store(Request $request, Student $student)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = ['student_id' => $student->id];

        foreach ($request->file('photos') as $file) {
            $this->service->uploadPhoto($data, $file);
        }

        return back()->with('success', 'Fotos enviadas com sucesso!');
    }

    /**
     * Exclui uma foto específica.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Photo $photo)
    {
        $this->service->deletePhoto($photo->id);

        return back()->with('success', 'Foto excluída com sucesso!');
    }
}
