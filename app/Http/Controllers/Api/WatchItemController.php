<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddWatchItemRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditWatchItemRequest;
use App\Services\WatchItemService;
use App\Services\WatchItemServiceImpl;

class WatchItemController extends Controller
{
    private $watchItemService;
    public function __construct(WatchItemService $watchItemService){
        $this->watchItemService = $watchItemService;
    }
    public function index(){
        $user = auth()->user();
        return $this->watchItemService->findAll($user->id);
    }
    public function store(AddWatchItemRequest $request){
        $data = $request->validated();
        $user = auth()->user();
        $watchItem = $this->watchItemService->store($data['movie_id'], $user->id);
        if ($watchItem == null){
            abort(400, "You cannot add same watch item twice");
        }
        return $watchItem;
    }
    public function update(EditWatchItemRequest $request){
        $data = $request->validated();
        $user = auth()->user();
        $watchItem = $this->watchItemService->update($data['movie_id'], $user->id, $data['watched']);
        if ($watchItem == null){
            abort(404, "Watchlist item not found");
        }
        return $watchItem;
    }
    public function delete($id){
        $found = $this->watchItemService->delete($id);
        if ($found == false){
            abort(404, "Watchlist item not found");
        }
        return response('Success', 200);
        
    }
}
