<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('nome',255);
            $table->integer('codigo');
            $table->char('codigo_original','30')->nullable();
            $table->char('unidade_estoque',3);
            $table->char('prateleira',15);
            $table->char('gaveta',15);
            $table->char('natureza_operacao',20);
            $table->char('ncm',8);
            $table->char('origem',1);
            $table->char('cest',7);
            $table->text('observacao')->nullable();
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
        Schema::dropIfExists('produtos');
    }
}
