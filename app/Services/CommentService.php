<?php
namespace App\Services;
interface CommentService {
    public function getAllByMovie($movieId);

    public function create($user, $comment);

}