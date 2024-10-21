<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Http\Requests\StoreUpdateVeiculoRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VeiculoController extends Controller
{
    // Lista todos os veículos
    public function index()
    {
        $veiculos = Veiculo::with('categoria')->get();
        return response()->json($veiculos);
    }

    // Mostra um veículo específico por ID
    public function show($id)
    {
        $veiculo = Veiculo::with('categoria')->find($id);
        if (!$veiculo) {
            return response()->json(['message' => 'Veículo não encontrado'], 404);
        }
        return response()->json($veiculo);
    }

    // Cria um novo veículo
    public function store(StoreUpdateVeiculoRequest $request)
    {
        // Processa o upload da imagem, se houver
        $imgPath = null;
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $img = $request->file('img');
            $imgName = Str::slug($request->modelo) . '.' . $img->getClientOriginalExtension();
            $imgPath = $img->storeAs('veiculos', $imgName, 'public'); // Salva em public/veiculos
        }

        // Cria um novo veículo e atribui os campos
        $veiculo = new Veiculo;
        $veiculo->id_categoria = $request->id_categoria;
        $veiculo->marca = $request->marca;
        $veiculo->modelo = $request->modelo;
        $veiculo->ano_fabricacao = $request->ano_fabricacao;
        $veiculo->placa = $request->placa;
        $veiculo->status = $request->status;
        $veiculo->valor = $request->valor;
        $veiculo->img = $imgPath; // Atribui o caminho da imagem

        $veiculo->save();

        // Retorna a resposta JSON
        return response()->json($veiculo, 201);
    }

    // Atualiza um veículo existente
    public function update(StoreUpdateVeiculoRequest $request, $id)
    {
        $veiculo = Veiculo::find($id);
        if (!$veiculo) {
            return response()->json(['message' => 'Veículo não encontrado'], 404);
        }

        // Processa o upload da nova imagem, se houver
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            // Apaga a imagem antiga, se existir
            if ($veiculo->img && file_exists(public_path("storage/{$veiculo->img}"))) {
                unlink(public_path("storage/{$veiculo->img}"));
            }

            $img = $request->file('img');
            $imgName = Str::slug($request->modelo) . '.' . $img->getClientOriginalExtension();
            $imgPath = $img->storeAs('veiculos', $imgName, 'public');

            // Armazena apenas o diretório
            $request->merge(['img' => 'veiculos/' . $imgName]);
        }

        // Atualiza os dados do veículo
        $veiculo->update($request->all());

        return response()->json($veiculo, 200);
    }

    // Deleta um veículo
    public function destroy($id)
    {
        $veiculo = Veiculo::find($id);
        if (!$veiculo) {
            return response()->json(['message' => 'Veículo não encontrado'], 404);
        }

        // Remove a imagem associada, se existir
        if ($veiculo->img && file_exists(public_path("storage/{$veiculo->img}"))) {
            unlink(public_path("storage/{$veiculo->img}"));
        }

        $veiculo->delete();

        return response()->json(['message' => 'Veículo deletado com sucesso'], 200);
    }
}
