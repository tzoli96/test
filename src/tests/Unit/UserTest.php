<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $data = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password'];
        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ]
            ]);

        $this->assertDatabaseHas('users', ['name' => 'John Doe', 'email' => 'john@example.com']);
    }

    public function test_get_user_by_id()
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->toJSON(),
                    'updated_at' => $user->updated_at->toJSON(),
                ]
            ]);
    }
}
