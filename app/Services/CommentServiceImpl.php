<?php
namespace App\Services;
use App\Movie;
use App\Comment;
class CommentServiceImpl implements CommentService{
    public function getAllByMovie($movieId){
        $movie = Movie::find($movieId);
        return $movie->comments()->with('user')->get();
    }

    public function create($user, $comment){
        $comment =  Comment::create([
            'movie_id' => $comment['movieId'],
            'text' => $comment['text'],
            'user_id' => $user->id
        ]);
        return $comment->load('user');
    }

}