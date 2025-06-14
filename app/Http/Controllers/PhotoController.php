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
        $request->validate(['photo' => 'required|image']);

        $data = ['student_id' => $student->id];

        $this->service->uploadPhoto($data, $request->file('photo'));

        return back()->with('success', 'Foto enviada com sucesso!');
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
