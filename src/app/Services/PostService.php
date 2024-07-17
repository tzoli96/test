<?php
namespace App\Services;

use App\Http\DTOs\PostDTO;
use App\Repositories\PostRepository;
use App\Models\Post;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAll();
    }

    public function getPostById($id)
    {
        return $this->postRepository->getById($id);
    }

    public function createPost(PostDTO $postDTO)
    {
        return $this->postRepository->create([
            'user_id' => $postDTO->user_id,
            'title' => $postDTO->title,
            'body' => $postDTO->body,
        ]);
    }

    public function updatePost(Post $post, PostDTO $postDTO)
    {
        return $this->postRepository->update($post, [
            'title' => $postDTO->title,
            'body' => $postDTO->body,
        ]);
    }

    public function deletePost(Post $post)
    {
        return $this->postRepository->delete($post);
    }

    public function getUserPosts($userId)
    {
        return $this->postRepository->getByUserId($userId);
    }
}
