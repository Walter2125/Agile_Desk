<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Buscar usuarios y mostrar resultados en la lista desplegable
    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%$query%")->get();

        $html = '';
        foreach ($users as $user) {
            $html .= '<div class="list-group-item d-flex justify-content-between align-items-center">';
            $html .= '<span>' . $user->name . '</span>';
            $html .= '<button type="button" class="btn btn-success btn-sm add-user" data-id="' . $user->id . '" data-name="' . $user->name . '">Agregar</button>';
            $html .= '</div>';
        }

        return response()->json($html);
    }
}
