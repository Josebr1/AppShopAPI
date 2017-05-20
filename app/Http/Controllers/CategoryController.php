<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 3:04 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function get()
    {
        $result = DB::select("SELECT * FROM category");
        return response()->json($result);
    }

    public function getById($id)
    {
        $result = app('db')->select('select * from category where id_category = :id', ['id' => $id]);
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json("user category folder", 404);
        }
    }

    /**
     * O parametro ta sendo inserido diretamente na string isso, errado -> revisao
     *
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByName($name)
    {
        $result = app('db')->select("SELECT * FROM category WHERE name LIKE '%" . $name . "%'");
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json("category not folder", 404);
        }
    }

    public function insert(Request $request)
    {
        try {
            $name = $request->input('name');
            $description = $request->input('description');
            $icon = $request->input('icon');

            DB::insert('insert into category (name, description, icon) values (?, ?, ?)', [$name, $description, $icon]);

            return response()->json("Categoria adicionada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao adicionar categoria, categoria pode já está cadastrada.", 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $name = $request->input('name');
            $description = $request->input('description');
            $icon = $request->input('icon');

            DB::update('update category set name=?, description=?, icon=? WHERE id_category=?', [$name, $description, $icon, $id]);

            return response()->json("Categoria atualizada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Error internal serve" . $e, 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::delete('delete from category WHERE id_category=?', [$id]);

            return response()->json("Categoria deletada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao deletar categoria.", 500);
        }
    }
}