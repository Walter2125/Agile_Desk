<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Buscar usuarios que coincidan con el nombre
        $users = User::where('name', 'like', "%$query%")->get(['id', 'name']); // Solo devuelve id y name

        return response()->json($users); // Retorna JSON en lugar de HTML
    }
}