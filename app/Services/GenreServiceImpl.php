<?php
namespace App\Services;
use App\Genre;
class GenreServiceImpl implements GenreService{
    public function findAll(){
        return Genre::all();
    }
}