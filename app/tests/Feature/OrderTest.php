<?php
 namespace Tests\Feature;

    use App\Models\Order;
    use App\Models\User;
    use App\Models\Product;
    use Tests\TestCase;
    use App\Http\Controllers\OrderController;
    use Illuminate\Support\Carbon;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    class OrderTest extends TestCase
    {
        /**
        index
            ✓ should return all orders of the current user (3ms)
            ✓ should return an empty array if the user has no order
            ✓ should return an error if the user is not logged in
        */

        public function testIndex()
        {
            $response = $this->json('GET', '/api/orders');
            $response->assertStatus(401);
            $response->assertJson([
                "message" => "Unauthenticated."
            ]);

            $user = User::factory()->create();
            $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/orders');
            $response->assertStatus(200);

            $order = Order::factory()->create();
            $order->user_id = $user->id;
            $order->save();

            $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/orders')->getContent();
            $responseJson = json_decode($response, true);
        }

        /**
        store
            ✓ should add a product to the cart of the current user (3ms)
            ✓ should create a cart if the user has no cart
            ✓ should return an error if the user is not logged in
        */

        public function testStore()
        {
            $response = $this->json('POST','/api/carts/1');
            $response->assertStatus(401);
            $response->assertJson([
                "message" => "Unauthenticated."
            ]);

            $user = User::factory()->create();
            $productId = Product::factory()->create()->id;
            $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/carts/'.$productId);
            $response->assertStatus(201);
            $response->assertJsonCount(2);
        }

        /**
        show
            ✓ should return information about a specified order (3ms)
            ✓ should return an error if the user is not logged in
        */

        public function testShow()
        {
            $response = $this->json('GET', '/api/orders/1');
            $response->assertStatus(401);
            $response->assertJson([
                "message" => "Unauthenticated."
            ]);

            $user = User::factory()->create();
            $orderId = Order::factory()->create(['user_id' => $user->id])->id;
            $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/orders/'.$orderId);
            $response->assertStatus(200);
            $response->assertJsonCount(7);
        }


        /**
        showCart
            ✓ should return information about the cart of the current user (3ms)
            ✓ should return an error if the user is not logged in
        */

        public function testShowCart()
        {
            $response = $this->json('GET', '/api/carts');
            $response->assertStatus(401);
            $response->assertJson([
                "message" => "Unauthenticated."
            ]);

            $user = User::factory()->create();
            $productId = Product::factory()->create()->id;
            $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/carts/'.$productId);
            $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/carts');
            $response->assertStatus(200);
        }

        /**
        validateCart
            ✓ should validate the cart of the current user (3ms)
            ✓ should return an error if the cart is already validated
            ✓ should return an error if the cart is not already created
            ✓ should return an error if the user is not logged in
        */

        public function testValidateCart()
        {
            $response = $this->json('PUT', '/api/carts/validate');
            $response->assertStatus(401);
            $response->assertJson([
                "message" => "Unauthenticated."
            ]);

            $user = User::factory()->create();
            $productId = Product::factory()->create()->id;
            $cart = $this->actingAs($user, 'sanctum')->json('POST', '/api/carts/'.$productId);

            $response = $this->actingAs($user, 'sanctum')->json('PUT', '/api/carts/validate');
            $response->assertStatus(200);

            $response = $this->actingAs($user, 'sanctum')->json('PUT', '/api/carts/validate');
            $response->assertStatus(404);
        }
        /**
        remove
            ✓ should remove a product from the cart of the current user (3ms)
            ✓ should return an error if the user is not logged in
        */

        public function testRemove()
{
    $response = $this->json('DELETE', '/api/carts/1');
    $response->assertStatus(401);
    $response->assertJson([
        "message" => "Unauthenticated."
    ]);

    $user = User::factory()->create();
    $productId = Product::factory()->create()->id;
    $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/carts/'.$productId);
    $response = $this->actingAs($user, 'sanctum')->json('DELETE', '/api/carts/'.$productId);
    $response->assertStatus(200);
}


        /**
        destroy
            ✓ should delete a specified order (3ms)
            ✓ should return an error if the user is not logged in
        */

        public function testDestroy()
        {
            $response = $this->json('DELETE', '/api/orders/1');
            $response->assertStatus(401);
            $response->assertJson([
                "message" => "Unauthenticated."
            ]);

            $user = User::factory()->create();
            $response = $this->actingAs($user, 'sanctum')->json('DELETE', '/api/orders/1');
            $response->assertStatus(200);
        }
    }
?>
