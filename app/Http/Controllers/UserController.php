<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 1:11 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function get()
    {
        $result = DB::select("SELECT * FROM user");
        return response()->json($result);
    }

    public function getById($id)
    {
        $result = app('db')->select('select * from user where id_user = :id', ['id' => $id]);
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json("user not folder", 404);
        }

    }

    public function addUser(Request $request)
    {
        try {
            $result = $this->getById($request->input('id_user'));

            if ($result->status() != 404) {
                return response()->json('Usuário já cadastrado', 200);
            } else {
                $id_user = $request->input('id_user');
                $name = $request->input('name');
                $email = $request->input('email');
                $photo = $request->input('photo_url');
                $phone = $request->input('phone');

                $save = DB::insert('insert into user (id_user, name, email, photo_url, phone) values (?, ?, ?, ?, ?)', [$id_user, $name, $email, $photo, $phone]);

                if ($save != null) {
                    return response()->json("Usuário adicionado com sucesso!", 200);
                } else {
                    return response()->json("Usuário já cadastrado / Nome de usuário já cadastrado.", 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json("Error internal serve", 500);
        }
    }

    public function updateUser($id, Request $request)
    {
        try {
            $name = $request->input('name');
            $email = $request->input('email');
            $photo = $request->input('photo_url');
            $phone = $request->input('phone');

            $result = DB::update('update user set name=?, email=?, photo_url=?, phone=? WHERE id_user=?', [$name, $email, $photo, $phone, $id]);

            if ($result != null) {
                return response()->json("Usuário atualizado com sucesso!", 200);
            } else {
                return response()->json("Erro ao atualizar o usuário.", 200);
            }

        } catch (\Exception $e) {
            return response()->json("Error internal serve", 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $result = DB::delete('delete from user WHERE id_user=?', [$id]);

            if ($result != null) {
                return response()->json("Usuário deletado com sucesso!", 200);
            } else {
                return response()->json("Erro ao deletar usuário.", 200);
            }

        } catch (\Exception $e) {
            return response()->json("Error internal serve", 500);
        }
    }

}