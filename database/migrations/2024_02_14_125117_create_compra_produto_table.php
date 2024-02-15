<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_compra', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBiginteger('compra_id');
            $table->unsignedBiginteger('produto_id');
            $table->integer('quantidade');
            $table->double('preco_total');
            $table->double('preco_com_desconto');

            $table->foreign('compra_id')->references('id')
                 ->on('compras')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')
                ->on('produtos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_compra');
    }
}
