<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/products', [
            'name' => 'Full Sliv T-shirt',
            'description' => 'Comfortable and stylish t-shirt',
            'price' => 200,
            'stock' => 20,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Product created successfully.',
            ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Full Sliv T-shirt',
            'price' => 200,
            'stock' => 20,
        ]);
    }
}