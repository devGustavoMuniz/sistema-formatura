<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iUserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    private iUserService $userService;

    public function __construct(iUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $filters = $request->only('search');
        $admins = $this->userService->getPaginatedAdmins($filters);

        return Inertia::render('Admin/Admins/Index', [
            'admins' => $admins,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Admins/Create');
    }

    public function store(Request $request)
    {
        $this->userService->createAdmin($request->all());
        return redirect()->route('admin.admins.index')->with('success', 'Administrador criado com sucesso!');
    }

    public function destroy(int $id)
    {
        $this->userService->deleteAdmin($id);
        return redirect()->route('admin.admins.index')->with('success', 'Administrador excluído com sucesso!');
    }
}
