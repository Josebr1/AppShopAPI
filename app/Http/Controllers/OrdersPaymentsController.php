<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 7:41 PM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersPaymentsController extends Controller
{
    public function store(Request $request)
    {
        $directPaymentRequest = new \PagSeguroDirectPaymentRequest();
        $directPaymentRequest->setPaymentMode('DEFAULT');
        $directPaymentRequest->setPaymentMethod('CREDIT_CARD');

        // Definiçao da moeda
        $directPaymentRequest->setCurrency('BRL');

        $items = $request->get('items');
        foreach ($items as $key => $item){
            $directPaymentRequest->addItem("00$key", $item['name_product'], $item['quantity'], $item['price']);
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $cpf = $request->get('cpf');
    }
}