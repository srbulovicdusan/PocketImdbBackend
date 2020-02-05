<?php
namespace App\Services;

use App\UserReaction;

class UserReactionServiceImpl implements UserReactionService{
    public function store($movieId, $type, $user){
        $user = auth()->user();
        $reaction = UserReaction::where('user_id', $user->id)->where('movie_id', $movieId)->get();
        if (count($reaction) != 0){
            abort(400, 'You cant like or dislike movie twice.');
        }
        return UserReaction::create([
            'user_id' => $user->id,
            'movie_id' => $movieId,
            'type' => $type,
        ]);
    }
}