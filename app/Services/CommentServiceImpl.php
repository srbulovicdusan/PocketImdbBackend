<?php
namespace App\Services;
use App\Movie;
use App\Comment;
class CommentServiceImpl implements CommentService{
    public function getAllByMovie($movieId, $page, $perPage){
        $movie = Movie::find($movieId);
        return array(
                'comments' => $movie->comments()->offset(intval($page) * intval($perPage))->take($perPage)->with('user')->get(),
                'total' => $movie->comments()->count(),
                'perPage' => $perPage,
                'currentPage' => $page
            
        );
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