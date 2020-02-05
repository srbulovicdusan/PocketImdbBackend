<?php
namespace App\Services;
interface WatchItemService {

    public function findAll($id);

    public function store($movieId, $userId);
    
    public function update($movieId, $userId, $watched);

    public function delete($id);
}