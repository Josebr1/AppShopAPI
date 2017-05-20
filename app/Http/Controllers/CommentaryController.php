<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 4:39 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentaryController extends Controller
{
    public function get()
    {
        $result = DB::select("SELECT * FROM commentary");
        return response()->json($result);
    }


    public function getById($id)
    {
        $result = app('db')->select('select * from commentary where id_commentary = :id', ['id' => $id]);
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json(" commentary not folder", 404);
        }
    }

    public function getByProduct($id)
    {
        $result = app('db')->select('select 
                                        commentary.text_commentary,
                                        commentary.date_commentary,
                                        user.name
                                        from commentary 
                                        left join product on commentary.product_id = product.id_product
                                        inner join user on commentary.user_id = user.id_user
                                        where product.id_product = :id
                                        order by commentary.date_commentary;', ['id' => $id]);
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json("commentary not folder", 404);
        }
    }

    public function insert(Request $request)
    {
        try {
            $text_commentary = $request->input('text_commentary');
            $product_id = $request->input('product_id');
            $user_id = $request->input('user_id');

            DB::insert('insert into commentary (text_commentary, product_id, user_id) values (?, ?, ?)', [$text_commentary, $product_id, $user_id]);

            return response()->json("Comentário adicionada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao adicionar Comentário.", 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $text_commentary = $request->input('text_commentary');

            DB::update('update commentary set text_commentary=? WHERE id_commentary=?', [$text_commentary, $id]);

            return response()->json("Comentário atualizada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Error internal serve" . $e, 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::delete('delete from commentary WHERE id_commentary=?', [$id]);

            return response()->json("Comentário deletada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao deletar Comentário.", 500);
        }
    }

}