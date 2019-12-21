<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'Item_Pedido';
    protected $fillable = [
        'Id_pedido', 'Id_produto', 'Preco_unidade', 'Quantidade', 'Valor_total'
    ];
    public function produto()
    {
        return $this->hasOne('App\Produto', 'Id', 'Id_produto');
    }
}
