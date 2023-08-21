<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return response()->json(['message' => 'Lista de pedidos obtida com sucesso', 'data' => $pedidos]);
    }

    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);
        return response()->json(['message' => 'Pedido detalhado com sucesso', 'data' => $pedido]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente' => 'required|string|max:255',
            'total' => 'required|numeric|min:0.1',
            'status' => 'required|in:pendente,processando,concluido',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pedido = Pedido::create($request->all());
        return response()->json(['message' => 'Pedido criado com sucesso', 'data' => $pedido], 201);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'cliente' => 'string|max:255',
            'total' => 'numeric|min:0',
            'status' => 'in:pendente,processando,concluido',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pedido->update($request->all());
        return response()->json(['message' => 'Pedido atualizado com sucesso', 'data' => $pedido], 200);
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return response()->json(['message' => 'Pedido excluído com sucesso'], 204);
    }
}
