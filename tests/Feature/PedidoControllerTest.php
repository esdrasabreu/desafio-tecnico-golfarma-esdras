<?php

namespace Tests\Feature;

use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PedidoControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testListarPedidos()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Pedido::factory(5)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/pedidos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => ['id', 'cliente', 'total', 'status', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function testCriarPedido()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
    
        $pedidoData = [
            'cliente' => 'João',
            'total' => 50.00,
            'status' => 'pendente',
        ];
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/pedidos', $pedidoData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Pedido criado com sucesso',
                'data' => [
                    'cliente' => 'João',
                    'total' => 50.00,
                    'status' => 'pendente',
                ]
            ]);

        $this->assertDatabaseHas('pedidos', $pedidoData);
    }

    public function testAtualizarPedido(){

        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
    
        $pedido = Pedido::factory()->create();
    
        $updateData = [
            'cliente' => 'Maria',
            'total' => 75.00,
            'status' => 'concluido',
        ];
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->putJson("/api/pedidos/{$pedido->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Pedido atualizado com sucesso',
                'data' => [
                    'cliente' => 'Maria',
                    'total' => 75.00,
                    'status' => 'concluido',
                ]
            ]);

        $this->assertDatabaseHas('pedidos', $updateData);
    }

    public function testExcluirPedido()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
    
        $pedido = Pedido::factory()->create();
    
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->deleteJson("/api/pedidos/{$pedido->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('pedidos', ['id' => $pedido->id]);
    }


}
