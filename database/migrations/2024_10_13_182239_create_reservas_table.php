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
            $table->enum('status', ['confirmada', 'cancelada', 'concluída'])->default('confirmada');
            $table->decimal('valor_total', 10, 2);

            $table->foreign('id_cliente')->references('id')->on('clientes');
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
