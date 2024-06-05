<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use App\Http\Controllers\ProductController;

class ProductTest extends TestCase
{
   /**
    * index
    *    ✓ should return all products (3ms)
    */
    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/products');
        $response->assertStatus(200);
    }

    /**
     * show
     *    ✓ should return a product (3ms)
     *    ✓ should return an error if the product does not exist
     */
    public function testShow()
    {
        $user = User::factory()->create();
        $productId = Product::factory()->create()->id;
        $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/carts/'.$productId);
        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/products/'.$productId);
        $response->assertStatus(200);

        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/products/999');
        $response->assertStatus(404);
    }

    /**
     * store
     *    ✓ should create a product (3ms)
     *    ✓ should return an error if the user is not logged in
     */
    public function testStore()
    {
        $response = $this->json('POST', '/api/products');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/products', [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'image' => 'test'
        ]);
        $response->assertStatus(201);
    }

    /**
     * update
     *    ✓ should modify a product (3ms)
     *    ✓ should return an error if the user is not logged in
     */
    public function testUpdate()
    {
        $response = $this->json('PUT', '/api/products/1');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $productId = Product::factory()->create()->id;
        $response = $this->actingAs($user, 'sanctum')->json('PUT', '/api/products/'.$productId, [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'quantity' => 10,
            'image' => 'test'
        ]);
        $response->assertStatus(200);
    }

    /**
     * destroy
     *    ✓ should delete a product (3ms)
     *    ✓ should return an error if the user is not logged in
     */
    public function testDestroy()
    {
        $response = $this->json('DELETE', '/api/products/1');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $productId = Product::factory()->create()->id;
        $response = $this->actingAs($user, 'sanctum')->json('DELETE', '/api/products/'.$productId);
        $response->assertStatus(200);
    }
}
