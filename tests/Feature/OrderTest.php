<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_fails_when_product_stock_is_insufficient(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $product = Product::create([
            'name' => 'Laptop',
            'description' => 'Business laptop',
            'price' => 55000,
            'stock' => 2,
        ]);

        $response = $this->postJson('/api/orders', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
        ]);

        $response->assertStatus(422);

        // Stock should remain unchanged.
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 2,
        ]);

        // Failed order should not be stored.
        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseCount('order_items', 0);
    }
}