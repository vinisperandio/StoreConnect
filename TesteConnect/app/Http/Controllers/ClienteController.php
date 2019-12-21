<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Cliente;
use App\Repositories\ClienteRepository;
use App\Repositories\Transations;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository();
    }

    public function get ()
    {
        $result = $this->clienteRepository->all();
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
            'email' => 'required',
            'senha' => 'required'
          ];

          $message = [
            'nome.required' => "Nome é obrigatório",
            'email.required' => "Email é obrigatório",
            'senha.required' => "Senha é obrigatório",
          ];

          $validator = Validator::make($request->all(), $rules, $message);

          if ($validator->fails()) {
            return response()->json([
              'error' => true,
              'message' => $validator->errors()->all(),
              'status' => 422
            ]);
          }

          $cliente = new Cliente();
          $cliente->Nome = $request['nome'];
          $cliente->Email = $request['email'];
          $cliente->Senha = $request['senha'];
          $cliente->DataCadastro = Carbon::now()->format('Y-m-d');

          $newReg = array();
          array_push($newReg, $cliente);
          $result = Transations::SalvarDeletarComTransaction($newReg);

          return response()->json([
            'error' => false,
            'data' => $cliente,
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
          'id' => 'required',
          'nome' => 'required',
          'email' => 'required',
          'senha' => 'required'
        ];

        $message = [
          'id.required' => "Entre em contato com o Admin do sistema",
          'nome.required' => "Nome é obrigatório",
          'email.required' => "Email é obrigatório",
          'senha.required' => "Senha é obrigatório",
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
          return response()->json([
            'error' => true,
            'message' => $validator->errors()->all(),
            'status' => 422
          ]);
        }

        $cliente = $this->clienteRepository->find($request['id']);
        $cliente->Nome = $request['nome'];
        $cliente->Email = $request['email'];
        $cliente->Senha = $request['senha'];

        $newReg = array();
        array_push($newReg, $cliente);
        $result = Transations::SalvarDeletarComTransaction($newReg);

        return response()->json([
          'error' => false,
          'data' => $cliente,
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

        $cliente = $this->clienteRepository->find($request['id']);

        $deleteReg = array();
        array_push($deleteReg, $cliente);
        $result = Transations::SalvarDeletarComTransaction([], $deleteReg);

        return response()->json([
          'error' => false,
          'data' => $cliente,
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