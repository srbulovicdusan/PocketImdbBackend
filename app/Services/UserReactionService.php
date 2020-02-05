<?php
namespace App\Services;
interface UserReactionService{
    public function store($movieId, $type, $user);
}