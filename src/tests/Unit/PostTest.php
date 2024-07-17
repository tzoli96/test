<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_post()
    {
        $user = User::factory()->create();
        $data = ['user_id' => $user->id, 'title' => 'Sample Post', 'body' => 'This is a sample post.'];
        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'title',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('posts', $data);
    }

    public function test_get_post()
    {
        $post = Post::factory()->create();
        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'user_id' => $post->user_id,
                    'title' => $post->title,
                    'body' => $post->body,
                    'created_at' => $post->created_at->toJSON(),
                    'updated_at' => $post->updated_at->toJSON(),
                ]
            ]);
    }
}
