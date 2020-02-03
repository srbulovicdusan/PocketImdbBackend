<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use App\Http\Requests\AddCommentRequest;
use App\Services\CommentService;
class CommentController extends Controller
{
    public function __construct(CommentService $commentService)
    {
        $this->service = $commentService;
    }
    public function getAllByMovie($movieId){
        $data = request(['page', 'perPage']);
        return $this->service->getAllByMovie($movieId, $data['page'], $data['perPage']);
    }
    public function create(AddCommentRequest $request){
        $user = auth()->user();
        $comment = $request->validated();
        return $this->service->create($user, $comment);
    }
}
