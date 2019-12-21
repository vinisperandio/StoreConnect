<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Illuminate\Http\Request;
use App\Pedido;
use App\Cliente;
use Carbon\Carbon;
use App\ItemPedido;
use App\Produto;
use App\Repositories\ItemPedidoRepository;
use App\Repositories\PedidoRepository;

class PedidoController extends Controller
{

    public function __construct()
    {
        $this->itemPedidoRepository = new ItemPedidoRepository();
        $this->pedidoRepository = new PedidoRepository();
    }

    public function get (Request $request) 
    {
        try {
          $rules = [
            'idCliente' => 'required'
          ];

          $message = [
            'idCliente.required' => "Entre em contato com o Admin do sistema"
          ];

          $validator = Validator::make($request->all(), $rules, $message);

          if ($validator->fails()) {
            return response()->json([
              'error' => true,
              'message' => $validator->errors()->all(),
              'status' => 422
            ]);
          }

          $pedidos = $this->pedidoRepository->findPedidosCliente($request['idCliente']);

          return response()->json([
            'error' => false,
            'data' => $pedidos,
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

    public function buy (Request $request) 
    {
        try {
          $rules = [
            'idCliente' => 'required',
            'produtos' => 'required'
          ];

          $message = [
            'idCliente.required' => "obrigatório",
            'produtos.required' => "produtos é obrigatório"
          ];

          $validator = Validator::make($request->all(), $rules, $message);
          if ($validator->fails()) {
            return response()->json([
              'error' => true,
              'message' => $validator->errors()->all(),
              'status' => 422
            ]);
          }

          $result = $this->pedidoRepository->save($request['idCliente'], $request['produtos']);

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