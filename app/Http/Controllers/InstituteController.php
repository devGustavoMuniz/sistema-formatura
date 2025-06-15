<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iInstituteService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstituteController extends Controller
{
    private iInstituteService $service;

    public function __construct(iInstituteService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $institutes = $this->service->getPaginatedInstitutes($filters);

        return Inertia::render('Admin/Institutes/Index', [
            'institutes' => $institutes,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Institutes/Create');
    }

    public function store(Request $request)
    {
        $this->service->createInstitute($request->all());
        return redirect()->route('admin.institutes.index')->with('success', 'Instituição criada com sucesso!');
    }

    public function edit(int $id)
    {
        $institute = $this->service->findInstituteById($id);
        return Inertia::render('Admin/Institutes/Edit', ['institute' => $institute]);
    }

    public function update(Request $request, int $id)
    {
        $this->service->updateInstitute($id, $request->all());
        return redirect()->route('admin.institutes.index')->with('success', 'Instituição atualizada com sucesso!');
    }

    public function destroy(int $id)
    {
        $this->service->deleteInstitute($id);
        return redirect()->route('admin.institutes.index')->with('success', 'Instituição excluída com sucesso!');
    }
}
