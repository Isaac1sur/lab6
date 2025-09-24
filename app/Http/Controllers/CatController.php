<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatController extends Controller
{
   
    public function index(Request $request)
    {
        $limit = $request->query('limit');
        $query = 'SELECT * FROM gatos';
        if ($limit) {
            $query .= ' LIMIT ' . intval($limit);
        }
        $gatos = DB::select($query);
        return response()->json($gatos);
    }

   
    public function show($id)
    {
        $gato = DB::select('SELECT * FROM gatos WHERE id = ?', [$id]);
        if (!$gato) {
            return response()->json(['error' => 'Gato no encontrado'], 404);
        }
        return response()->json($gato[0]);
    }


    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        DB::insert('INSERT INTO gatos (nombre) VALUES (?)', [$nombre]);
        return response()->json(['message' => 'Gato agregado exitosamente'], 201);
    }


    public function update(Request $request, $id)
    {
        $nombre = $request->input('nombre');
        $updated = DB::update('UPDATE gatos SET nombre = ? WHERE id = ?', [$nombre, $id]);

        if ($updated === 0) {
            return response()->json(['error' => 'Gato no encontrado'], 404);
        }

        return response()->json(['message' => 'Gato actualizado']);
    }


    public function destroy($id)
    {
        $deleted = DB::delete('DELETE FROM gatos WHERE id = ?', [$id]);

        if ($deleted === 0) {
            return response()->json(['error' => 'Gato no encontrado'], 404);
        }

        return response()->json(['message' => 'Gato eliminado']);
    }
}