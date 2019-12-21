<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClienteTableSeeder::class);
        $this->call(ProdutoTableSeeder::class);
        $this->call(PedidoTableSeeder::class);
        $this->call(ItemPedidoTableSeeder::class);
    }
}
