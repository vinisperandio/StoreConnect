<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Produto;
use App\Repositories\ProdutoRepository;
use App\Repositories\Transations;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->produtoRepository = new ProdutoRepository();
    }

    public function get ()
    {
        $result = $this->produtoRepository->all();
        
        return response()->json([
            'error' => false,
            'data' => $result,
            'status' => 200
        ]);
    }

    public function save (Request $request)
    {
        try {
          $rules = [
            'nome' => 'required',
            'unidade' => 'required',
            'preco' => 'required'
          ];

          $message = [
            'nome.required' => "Nome é obrigatório",
            'unidade.required' => "Unidade é obrigatório",
            'preco.required' => "Preço é obrigatório",
          ];

          $validator = Validator::make($request->all(), $rules, $message);

          if ($validator->fails()) {
            return response()->json([
              'error' => true,
              'message' => $validator->errors()->all(),
              'status' => 422
            ]);
          }

          $produto = new Produto();
          $produto->Nome = $request['nome'];
          $produto->Unidade = $request['unidade'];
          $produto->Preco = $request['preco'];

          $newReg = array();
          array_push($newReg, $produto);
          $result = Transations::SalvarDeletarComTransaction($newReg);

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

    public function update (Request $request)
    {
      try {
        $rules = [
          'nome' => 'required',
          'unidade' => 'required',
          'preco' => 'required'
        ];

        $message = [
          'nome.required' => "Nome é obrigatório",
          'unidade.required' => "Unidade é obrigatório",
          'preco.required' => "Preço é obrigatório",
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
          return response()->json([
            'error' => true,
            'message' => $validator->errors()->all(),
            'status' => 422
          ]);
        }

        $produto = $this->produtoRepository->find($request['id']);
        $produto->Nome = $request['nome'];
        $produto->Unidade = $request['unidade'];
        $produto->Preco = $request['preco'];

        $newReg = array();
        array_push($newReg, $produto);
        $result = Transations::SalvarDeletarComTransaction($newReg);

        return response()->json([
          'error' => false,
          'data' => $produto,
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

    public function delete (Request $request)
    {
      try {
        $rules = [
          'id' => 'required'
        ];

        $message = [
          'id.required' => "Entre em contato com o Admin do sistema"
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
          return response()->json([
            'error' => true,
            'message' => $validator->errors()->all(),
            'status' => 422
          ]);
        }

        $produto = $this->produtoRepository->find($request['id']);

        $deleteReg = array();
        array_push($deleteReg, $produto);
        $result = Transations::SalvarDeletarComTransaction([], $deleteReg);

        return response()->json([
          'error' => false,
          'data' => $produto,
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