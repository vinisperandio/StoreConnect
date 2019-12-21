<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pedido', function (Blueprint $table) {
            $table->primary(['Id_pedido', 'Id_produto']);
            $table->unsignedInteger('Id_pedido');
            $table->unsignedInteger('Id_produto');
            $table->double('Preco_unidade');
            $table->integer('Quantidade');
            $table->double('Valor_total');
            $table->foreign('Id_pedido')->references('Id')->on('Pedido')->onDelete('cascade');
            $table->foreign('Id_produto')->references('Id')->on('Produto')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_pedido');
    }
}
