<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 5:12 PM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function get()
    {
        $result = DB::select("SELECT * FROM order_user");
        return response()->json($result);
    }

    public function getById($id)
    {
        $result = app('db')->select('select * from order_user where id_order = :id', ['id' => $id]);
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json("order not folder", 404);
        }
    }

    public function getAllProducts($id)
    {
        $result = app('db')->select('select 
                                    order_items.quantity,
                                    product.name,
                                    product.id_product
                                    from order_items 
                                    left join order_user on order_items.order_id = order_user.id_order
                                    inner join product on order_items.product_id = product.id_product 
                                    where order_user.id_order = :id', ['id' => $id]);
        if ($result != null) {
            return response()->json($result);
        } else {
            return response()->json("product not folder", 404);
        }
    }

    public function insert(Request $request)
    {
        try {
            $description_order = $request->input('description_order');
            $address = $request->input('address');
            $status = "Pedido realizado";
            $form_payment = $request->input('form_payment');
            $user_id = $request->input('user_id');

            $resultID = DB::insert('insert into order_user (description_order, address, status, form_payment, user_id) values (?, ?, ?, ?, ?)',
                [$description_order, $address, $status, $form_payment, $user_id]);

            if ($resultID) {
                $rowId = DB::connection()->getPdo()->lastInsertId();

                $items = $request->input('items');

                foreach ($items as $key => $item) {
                    $quantity = $item['quantity'];
                    $id_product = $item['product_id'];

                    DB::insert('insert into order_items (quantity, order_id, product_id) values (?, ?, ?)',
                        [$quantity, $rowId, $id_product]);
                }
            }
            return response()->json("Pedido realizado com sucesso", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao realizado pedido." . $e, 500);
        }
    }

    public function updateStatus($id, Request $request)
    {
        try {
            $status = $request->input('status');

            DB::update('update order_user set status=? WHERE id_order=?', [$status, $id]);

            return response()->json("Status atualizada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Error internal serve" . $e, 500);
        }
    }

    public function updateAddress($id, Request $request)
    {
        try {
            $address = $request->input('address');

            DB::update('update order_user set address=? WHERE id_order=?', [$address, $id]);

            return response()->json("Endereço atualizada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Error internal serve" . $e, 500);
        }
    }

    /* Not delete */
    public function delete($id)
    {
        try {
            DB::delete('delete from order_user WHERE id_order=?', [$id]);

            return response()->json("Pedido deletada com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao deletar Pedido.", 500);
        }
    }
}