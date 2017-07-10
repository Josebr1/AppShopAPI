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
use Mockery\Exception;

class OrderController extends Controller
{
    public function get()
    {
        try {
            $result = DB::select("select * from user inner join order_user on 
                                user.id_user = order_user.user_id order by order_user.date_order DESC");
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getById($id)
    {
        try {
            $result = app('db')->select('
                                select * from user inner join order_user on 
                                user.id_user = order_user.user_id where 
                                order_user.id_order = :id order by order_user.date_order DESC', ['id' => $id]);
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        } catch (Exception $e) {
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllUsersFormPayment($id)
    {
        try {
            $result = app('db')->select('select * from user inner join order_user on 
                                            user.id_user = order_user.user_id where
                                            order_user.form_payment = :id and order_user.status = \'Pedido Realizado\' ORDER BY 
                                            order_user.date_order DESC', ['id' => $id]);
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        } catch (Exception $e) {
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllOrderPlaced()
    {
        try {
            $result = app('db')->select('select * from user inner join order_user on 
user.id_user = order_user.user_id where order_user.status = \'Pedido Realizado\' ORDER BY order_user.date_order DESC');

            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        } catch (Exception $e) {
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllCanceledRequest()
    {
        try{
            $result = app('db')->select('select * from user inner join order_user on 
user.id_user = order_user.user_id where order_user.status = \'Pedido Cancelado\' ORDER BY order_user.date_order DESC');
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllOrderLeftForDelivery()
    {
        try{
            $result = app('db')->select('select * from user inner join order_user on 
user.id_user = order_user.user_id where order_user.status = \'Pedido saiu para entrega\' ORDER BY order_user.date_order DESC');
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("Error", 500);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllOrderCompleted()
    {
        try{
            $result = app('db')->select('select * from user inner join order_user on 
user.id_user = order_user.user_id where order_user.status = \'Pedido Finalizado\' ORDER BY order_user.date_order DESC');
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }


    public function getUserTopSales()
    {
        try{
            $result = app('db')->select('select 
                                COUNT(user.id_user),
                                user.name,
                                user.email,
                                user.phone
                                from 
                                user, order_user order by count(user.id_user)');
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllMonth()
    {
        try{
            $result = app('db')->select('select count(id_order) as count from order_user where month(date_order) = month(now())');
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }

    }

    public function getAllDay()
    {
        try{
            $result = app('db')->select('select count(id_order) as count from order_user where day(date_order) = day(now())');
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllProducts($id)
    {
        try{
            $result = app('db')->select('select 
                                    order_items.quantity,
                                    product.name,
                                    product.product_image,
                                    product.id_product,
                                    product.price
                                    from order_items 
                                    left join order_user on order_items.order_id = order_user.id_order
                                    inner join product on order_items.product_id = product.id_product 
                                    where order_user.id_order = :id', ['id' => $id]);
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("product not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getAllProductsOrder($id)
    {
        try{
            $result = DB::select('select 
                                        user.name,
                                        order_user.description_order,
                                        order_user.address, 
                                        order_user.status 
                                        from 
                                        user, order_user where
                                        user.id_user = :idUser and order_user.user_id = :id 
                                        order by date_order desc', ['idUser' => $id, 'id' => $id]);
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("order not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function insert(Request $request)
    {
        try {
            $description_order = $request->input('description_order');
            $address = $request->input('address');
            $status = "Pedido Realizado";
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

            if ($request != null) {
                DB::update('update order_user set status=? WHERE id_order=?', [$status, $id]);

                return response()->json("Status atualizada com sucesso!(" . $status . ')', 200);
            } else {
                return response()->json("Not foud(" . $status . ')', 404);
            }
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