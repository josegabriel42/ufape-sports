<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoPromocaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_promocao', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBiginteger('produto_id');
            $table->unsignedBiginteger('promocao_id');


            $table->foreign('produto_id')->references('id')
                 ->on('produtos')->onDelete('cascade');
            $table->foreign('promocao_id')->references('id')
                ->on('promocoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_promocao');
    }
}
