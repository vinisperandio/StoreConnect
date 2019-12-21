<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cliente')->insert([
            "Id" => "1",
            "Nome" => "vinicius",
            "Email" => "vini@ufv.br",
            "Senha" => "12311",
            "DataCadastro" => "2019-01-08",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('cliente')->insert([
            "Id" => "2",
            "Nome" => "fernando",
            "Email" => "fe@ufv.br",
            "Senha" => "12322",
            "DataCadastro" => "2019-02-08",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('cliente')->insert([
            "Id" => "3",
            "Nome" => "larissa",
            "Email" => "la@ufv.br",
            "Senha" => "12333",
            "DataCadastro" => "2019-03-08",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('cliente')->insert([
            "Id" => "4",
            "Nome" => "gafanhoto",
            "Email" => "ro@ufv.br",
            "Senha" => "12344",
            "DataCadastro" => "2019-04-08",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $this->command->info('CLIENTE created');
    }
}
