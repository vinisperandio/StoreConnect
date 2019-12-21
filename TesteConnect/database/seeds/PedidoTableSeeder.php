<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PedidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Pedido')->insert([
            "Id" => "1",
            "Id_cliente" => "1",
            "Data_pedido" => Carbon::now()->format('Y-m-d H:i:s'),
            "Valor_total" => "20",
        ]);

        DB::table('Pedido')->insert([
            "Id" => "2",
            "Id_cliente" => "3",
            "Data_pedido" => Carbon::now()->format('Y-m-d H:i:s'),
            "Valor_total" => "150",
        ]);

        DB::table('Pedido')->insert([
            "Id" => "3",
            "Id_cliente" => "3",
            "Data_pedido" => Carbon::now()->format('Y-m-d H:i:s'),
            "Valor_total" => "100",
        ]);
        $this->command->info('PEDIDOS created');
    }
}
