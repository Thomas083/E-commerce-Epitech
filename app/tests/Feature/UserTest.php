<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Http\Controllers\UserController;

class UserTest extends TestCase
{
    /**
    index
       ✓ should return all users (3ms)
       ✓ should return an error if the user is not logged in
    */
    public function testIndex() {
        $response = $this->json('GET', '/api/users');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/users');
        $response->assertStatus(200);
    }

    /**
    register
       ✓ should create a new user (3ms)
       ✓ should return an error if the user is already registered
     */
    public function testRegister() {
        $response = $this->post('/api/register', [
            'login' => 'test',
            'email' => 'miaw@hotmail.fr',
            'password' => 'mi@w.UwU',
            'firstname' => 'test',
            'lastname' => 'test',
        ]);
        $response->assertStatus(201);
    }

    /**
     * login
     *    ✓ should log the user in (3ms)
     *    ✓ should return an error if the user is not registered
     */
    public function testLogin() {
        $response = $this->post('/api/register', [
            'login' => 'test',
            'email' => 'miaw@hotmail.fr',
            'password' => 'mi@w.UwU',
            'firstname' => 'test',
            'lastname' => 'test',
        ]);
        $response = $this->post('/api/login', [
            'login' => 'test',
            'password' => 'mi@w.UwU',
        ]);
        $response->assertStatus(201);
    }

    /**
     * logout
     *    ✓ should log the user out (3ms)
     *    ✓ should return an error if the user is not logged in
     */

    public function testLogout() {
        $response = $this->json('GET','/api/logout');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/logout');
        $response->assertStatus(204);
    }

    /**
     * show
     *    ✓ should return the current user(3ms)
     *    ✓ should return an error if the user is not logged in
     */

    public function testShow() {
        $response = $this->json('GET', '/api/users');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get('/api/users');
        $response->assertStatus(200);
    }

    /**
     * update
     *    ✓ should update the current user(3ms)
     *    ✓ should return an error if the user is not logged in
     */
    public function testUpdate() {
        $response = $this->json('PUT', '/api/users');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->put('/api/users', [
            'login' => 'mi@w',
            'email' => 'm1aw@hotmail.fr',
            'password' => 'Mi@w.UwU',
            'firstname' => 'test',
            'lastname' => 'test',
        ]);
        $response->assertStatus(200);
    }

    /**
     * destroy
     *    ✓ should delete the current user(3ms)
     *    ✓ should return an error if the user is not logged in
     */
    public function testDestroy() {
        $response = $this->json('DELETE', '/api/users');
        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->delete('/api/users');
        $response->assertStatus(204);
    }

}
