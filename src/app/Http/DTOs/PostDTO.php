<?php
namespace App\Http\DTOs;

class PostDTO
{
    public $user_id;
    public $title;
    public $body;

    public function __construct($user_id, $title, $body)
    {
        $this->user_id = $user_id;
        $this->title = $title;
        $this->body = $body;
    }
}
