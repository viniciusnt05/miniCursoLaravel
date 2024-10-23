<?php

namespace App\Http\Controllers;

use App\Http\Resources\VeiculoResource;
use App\Models\Veiculo;
use App\Http\Requests\StoreUpdateVeiculoRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VeiculoController extends Controller
{
    // Lista todos os veículos
//    public function index()
//    {
//        $veiculos = Veiculo::with('categoria')->get();
//        return response()->json($veiculos);
//    }

    public function index()
    {
        $veiculos = Veiculo::all();
        return VeiculoResource::collection($veiculos);
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
        $veiculo = Veiculo::create($request->all());

        // Salva o veículo para obter o ID
        $veiculo->save();

        // Processa o upload da imagem, se houver
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $img = $request->file('img');
            $imgName = Str::slug($request->modelo) . '.' . $img->getClientOriginalExtension();

            // Define o caminho correto de armazenamento
            $imgPath = $img->storeAs("veiculos/{$veiculo->id}", $imgName, 'public');

            // Atualiza o caminho da imagem no veículo
            $veiculo->img = "storage/veiculos/{$veiculo->id}/{$imgName}";
            $veiculo->save();
        }

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

    public function search($query)
    {
        $veiculos = Veiculo::with('categoria')
            ->where('modelo', 'LIKE', "%{$query}%")
            ->orWhere('marca', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($veiculos);
    }
}
