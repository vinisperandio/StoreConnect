<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\ItemPedido;

class ItemPedidoRepository extends BaseRepository implements ItemPedidoRepositoryInterface
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = ItemPedido::class;
        parent::__construct();
    }

    public function findItensdoPedido ($id)
    {
        return $this->model->where('Id_pedido', $id)->with([
            'produto'
        ])->get();
    }
}