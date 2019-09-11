<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItenspedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('preco'); // pq o preço do produto pode ser alterado e alteraria aqui também
            $table->integer('quantidade'); 

            $table->integer('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');;

            $table->integer('pedido_id')->unsigned();
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');;
            //$table->integer('produto_id')->unsigned()->nullable(false);
            //$table->integer('pedido_id')->unsigned()->nullable(false);
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
        Schema::dropIfExists('itens_pedidos');
    }
}
