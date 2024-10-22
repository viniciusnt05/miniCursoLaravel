<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_veiculo');
            $table->date('data_retirada');
            $table->date('data_devolucao_prevista');
            $table->decimal('valor_total', 10, 2);
            $table->integer('qtd_dias');
            $table->enum('status', ['confirmada', 'cancelada', 'concluida'])->default('confirmada');

            $table->foreign('id_cliente')->references('id')->on('usuarios');
            $table->foreign('id_veiculo')->references('id')->on('veiculos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
