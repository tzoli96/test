<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->post->all();
    }

    public function getById($id)
    {
        return $this->post->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->post->create($data);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post)
    {
        $post->delete();
        return true;
    }

    public function getByUserId($userId)
    {
        return $this->post->where('user_id', $userId)->get();
    }
}
