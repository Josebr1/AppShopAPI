<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/27/17
 * Time: 9:34 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PagarMe;
use PagarMe_Transaction;


class PagarMeController extends Controller
{
    public function index(Request $request)
    {

        $value = $request->input('valor_total');
        $token = $request->input('token_card');

        Pagarme::setApiKey("ak_test_nzWbYau4ZsLtPm567Sx4oInCLSEtMt");
        $transaction = new PagarMe_Transaction(array(
            'amount' => ($value * 100),
            'card_hash' => $token
        ));
        $transaction->charge();
        $status = $transaction->status;

        if (strcasecmp($status, 'refused') == 0) {
            return response()->json("Infezlimente nao foi possivel realizar a compra." . $status);
        } else {
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
    }
}