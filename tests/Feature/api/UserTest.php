<?php

namespace Tests\Feature\api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all()
    {
        $response = $this->getJson('api/users');
        $response->assertStatus(200);
    }

    public function test_get_all_with_total()
    {
        User::factory()->count(10)->create();

        $response = $this->getJson('api/users');
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function test_get_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("api/users/{$user->id}");
        $response->assertStatus(200);
    }

    public function test_get_user_not_found()
    {
        $response = $this->getJson('api/users/fake_value');
        $response->assertStatus(404);
    }

    public function test_validations_create()
    {
        $data = [];

        $response = $this->postJson('api/users', $data);
        $response->assertStatus(422);
    }

    public function test_create()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => '12345678'
        ];

        $response = $this->postJson('api/users', $data);
        $response->assertStatus(201);
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $data = $this->get_fake_valid_data();

        $response = $this->putJson("api/users/{$user->id}", $data);
        $response->assertStatus(200);
    }

    public function test_update_invalid_identify()
    {
        $data = $this->get_fake_valid_data();

        $response = $this->putJson('/todos/fake_value', $data);
        $response->assertStatus(404);
    }

    public function test_update_validations()
    {
        $user = User::factory()->create();

        $data = [];

        $response = $this->putJson("api/users/{$user->id}", $data);
        $response->assertStatus(422);
    }

    public function test_delete()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("api/users/{$user->id}");
        $response->assertStatus(204);
    }

    private function get_fake_valid_data()
    {
        return [
            'name' => 'John Doe',
            'email' => 'johndoe@test.com',
            'password' => '12345678',
        ];
    }
}
