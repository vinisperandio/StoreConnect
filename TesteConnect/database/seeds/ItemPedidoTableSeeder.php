<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemPedidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Item_pedido')->insert([
            "Id_pedido" => "1",
            "Id_produto" => "2",
            "Preco_unidade" => "10",
            "Quantidade" => "1",
            'Valor_total' => "10",
        ]);

        DB::table('Item_pedido')->insert([
            "Id_pedido" => "1",
            "Id_produto" => "3",
            "Preco_unidade" => "5",
            "Quantidade" => "2",
            'Valor_total' => "10",
        ]);

        DB::table('Item_pedido')->insert([
            "Id_pedido" => "2",
            "Id_produto" => "2",
            "Preco_unidade" => "10",
            "Quantidade" => "15",
            'Valor_total' => "150",
        ]);

        DB::table('Item_pedido')->insert([
            "Id_pedido" => "3",
            "Id_produto" => "1",
            "Preco_unidade" => "0.2",
            "Quantidade" => "50",
            'Valor_total' => "10",
        ]);

        DB::table('Item_pedido')->insert([
            "Id_pedido" => "3",
            "Id_produto" => "2",
            "Preco_unidade" => "10",
            "Quantidade" => "7",
            'Valor_total' => "70",
        ]);

        DB::table('Item_pedido')->insert([
            "Id_pedido" => "3",
            "Id_produto" => "3",
            "Preco_unidade" => "5",
            "Quantidade" => "4",
            'Valor_total' => "20",
        ]);

        $this->command->info('ITEM_PEDIDOS created');
    }
}
