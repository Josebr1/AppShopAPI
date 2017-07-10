<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 4:24 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ProductController extends Controller
{
    public function get()
    {
        try{
            $result = DB::select("SELECT * FROM product");
            return response()->json($result);
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getById($id)
    {
        try{
            $result = app('db')->select('select * from product where id_product = :id', ['id' => $id]);
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("product not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getByIdCategory($id)
    {
        try{
            $result = app('db')->select('select * from product where id_category = :id', ['id' => $id]);
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("product not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getByName($name)
    {
        try{
            $result = app('db')->select("SELECT * FROM product WHERE name LIKE '%" . $name . "%'");
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("product not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function getHomeProducts()
    {
        try{
            $result = app('db')->select("select * from product ORDER BY RAND() limit 2;");
            if ($result != null) {
                return response()->json($result);
            } else {
                return response()->json("product not folder", 404);
            }
        }catch (Exception $e){
            return response()->json("Error: " . $e->getMessage(), 500);
        }
    }

    public function insert(Request $request)
    {
        try {
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $product_image = $request->input('product_image');
            $id_category = $request->input('id_category');

            DB::insert('insert into product (name, description, price, product_image, id_category) values (?, ?, ?, ?, ?)', [$name, $description, $price, $product_image, $id_category]);

            return response()->json("Produto adicionado com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao adicionar Produto, Produto pode já está cadastrada.", 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $product_image = $request->input('product_image');

            if($product_image != null){
                DB::update('update product set name=?, description=?, price=?, product_image=?  WHERE id_product=?', [$name, $description, $price, $product_image, $id]);
            }else{
                DB::update('update product set name=?, description=?, price=?  WHERE id_product=?', [$name, $description, $price, $id]);
            }
            
            return response()->json("Produto atualizado com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao atualizar produto." . $e, 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::delete('delete from product WHERE id_product=?', [$id]);

            return response()->json("Produto deletado com sucesso!", 200);
        } catch (\Exception $e) {
            return response()->json("Erro ao deletar o produto.", 500);
        }
    }
}