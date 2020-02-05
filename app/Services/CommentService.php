<?php
namespace App\Services;
interface CommentService {
    public function getAllByMovie($movieId, $page, $perPage);

    public function create($user, $comment);

}