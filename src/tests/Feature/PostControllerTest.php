<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/posts', [
            'user_id' => $user->id,
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'title' => 'Test Post',
                    'body' => 'This is a test post.',
                ],
            ]);

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ]);
    }

    public function test_can_get_post_by_id()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'body' => $post->body,
                ],
            ]);
    }

    public function test_can_get_all_posts()
    {
        $posts = Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'user_id', 'title', 'body', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->create();

        $response = $this->putJson('/api/posts/' . $post->id, [
            'title' => 'Updated Post',
            'body' => 'This is an updated post.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => 'Updated Post',
                    'body' => 'This is an updated post.',
                ],
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post',
            'body' => 'This is an updated post.',
        ]);
    }

    public function test_can_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson('/api/posts/' . $post->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_can_get_user_posts()
    {
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/users/' . $user->id . '/posts');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'user_id', 'title', 'body', 'created_at', 'updated_at'],
                ],
            ]);
    }
}
