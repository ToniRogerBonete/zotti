<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaPrecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_precos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->integer('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->integer('lista_id')->unsigned();
            $table->foreign('lista_id')->references('id')->on('listas');
            $table->decimal('indice_venda','6','2');
            $table->char('tipo',3);
            $table->decimal('indice_compra','6','2');
            $table->char('codigo_material',20);
            $table->decimal('preco','6','2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_precos');
    }
}
