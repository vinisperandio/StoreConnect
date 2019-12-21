<?php

namespace App\Repositories;

use Exception;
use App\Repositories\BaseRepository;
use App\Pedido;
use App\ItemPedido;
use Carbon\Carbon;
use App\Produto;
use DB;

class PedidoRepository extends BaseRepository implements PedidoRepositoryInterface
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = Pedido::class;
        parent::__construct();
    }

    public function findPedidosCliente ($id)
    {
        return $this->model->where('Id_cliente', $id)->get();
    }

    public function save ($idCliente, $produtos)
    {
        try {
            DB::transaction(function () use ($idCliente, $produtos){
                
                $pedido = new Pedido();
                $pedido->Id_cliente = $idCliente;
                $pedido->Data_pedido = Carbon::now()->format('Y-m-d H:i:s');
                $pedido->Valor_total = "0";
                $pedido->save();

                foreach($produtos as $item){
                    $produto = Produto::find($item['id']);
                    if ($item['qtd'] <= $produto->Unidade) {
                        $itemNovo = ItemPedido::create([
                                        'Id_pedido' => $pedido->Id,
                                        'Id_produto' => $produto->Id,
                                        'Preco_unidade' => $produto->Preco,
                                        'Quantidade' => $item['qtd'],
                                        'Valor_total' => $item['qtd'] * $produto->Preco
                                    ]);
                        
                        $produto->Unidade -= $item['qtd'];
                        $produto->save();
                        $pedido->Valor_total += $itemNovo->Valor_total;
                    
                    } else {
                        $response['produtos'] = array("idProduto" => $produto->Nome);
                    }
                };
                ( $itemNovo) ? $pedido->save() : null;
            });
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}