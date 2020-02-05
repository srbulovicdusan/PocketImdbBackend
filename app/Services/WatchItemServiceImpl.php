<?php
namespace App\Services;
use App\WatchItem;
class WatchItemServiceImpl implements WatchItemService {

    public function findAll($id){
        return WatchItem::where('user_id', $id)->with('movie')->get();
    }

    public function store($movieId, $userId){
        $watchItem = WatchItem::where('movie_id', $movieId)->where('user_id', $userId)->get()->first();
        if ($watchItem == null){
            return WatchItem::create([
                'movie_id'=>$movieId,
                'user_id'=>$userId,
                'watched'=>false,
            ])->load('movie');
        }
        return null;
    }
    
    public function update($movieId, $userId, $watched){
        $watchItem = WatchItem::where('movie_id', $movieId)->where('user_id', $userId)->get()->first();
        if ($watchItem != null){
            $watchItem->watched = $watched;
            $watchItem->save();
            return $watchItem->load('movie');
        }
        return null;
    }

    public function delete($id){
       $watchItemToDelete =  WatchItem::find($id);
       if ($watchItemToDelete != null){
           $watchItemToDelete->delete();
           return true;
       }else{
           return false;
       }
    }
}