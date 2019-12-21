<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProdutoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Produto')->insert([
            "Id" => "1",
            "Nome" => "Sashimi",
            "Preco" => "0.20",
            "Unidade" => "20",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('Produto')->insert([
            "Id" => "2",
            "Nome" => "Agemono",
            "Preco" => "10.00",
            "Unidade" => "3",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('Produto')->insert([
            "Id" => "3",
            "Nome" => "Temaki",
            "Preco" => "5.00",
            "Unidade" => "15",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('Produto')->insert([
            "Id" => "4",
            "Nome" => "Yakimono",
            "Preco" => "4.00",
            "Unidade" => "5",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->command->info('PRODUTOS created');
    }
}
