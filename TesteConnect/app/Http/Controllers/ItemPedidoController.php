<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Illuminate\Http\Request;
use App\Repositories\ItemPedidoRepository;

class ItemPedidoController extends Controller
{

    public function __construct()
    {
        $this->itemPedidoRepository = new ItemPedidoRepository();
    }

    public function get (Request $request) 
    {
        try {
          $rules = [
            'idPedido' => 'required'
          ];

          $message = [
            'idPedido.required' => "Entre em contato com o Admin do sistema"
          ];

          $validator = Validator::make($request->all(), $rules, $message);

          if ($validator->fails()) {
            return response()->json([
              'error' => true,
              'message' => $validator->errors()->all(),
              'status' => 422
            ]);
          }

          $itemPedido = $this->itemPedidoRepository->findItensdoPedido($request['idPedido']);

          $result = array();
          foreach ($itemPedido as $key) {
            array_push($result, [
              'Id' => $key->produto->Id,
              'Nome' => $key->produto->Nome,
              'Qtd' => $key->Quantidade,
              'Preco' => $key->Preco_unidade
            ]);
          }

          return response()->json([
            'error' => false,
            'data' => $result,
            'status' => 200
          ]);

        } catch (Exception $e) {
          return response()->json([
            'error' => true,
            'data' => $e->getMessage(),
            'status' => 200
          ]);
        }
    }

}