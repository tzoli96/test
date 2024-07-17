<?php
namespace App\Http\Controllers;

use App\Http\DTOs\PostDTO;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $postDTO = new PostDTO(
            $request->input('user_id'),
            $request->input('title'),
            $request->input('body')
        );

        $post = $this->postService->createPost($postDTO);
        return new PostResource($post);
    }

    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->postService->getPostById($id);

        $postDTO = new PostDTO(
            $post->user_id,
            $request->input('title'),
            $request->input('body')
        );

        $post = $this->postService->updatePost($post, $postDTO);
        return new PostResource($post);
    }

    public function destroy($id)
    {
        $post = $this->postService->getPostById($id);
        $this->postService->deletePost($post);

        return response()->json(null, 204);
    }

    public function getUserPosts($userId)
    {
        $posts = $this->postService->getUserPosts($userId);
        return PostResource::collection($posts);
    }
}
