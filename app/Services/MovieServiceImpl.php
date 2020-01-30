<?php
namespace App\Services;
use App\Movie;
class MovieServiceImpl implements MovieService{
    public function getAllMoviesByPage($page, $perPage){
            
            return array(
                'movies' => Movie::offset($page * $perPage)->take($perPage)->get(),
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => Movie::all()->count() % intval($perPage) == 0 ? Movie::all()->count() / intval($perPage) : Movie::all()->count() / intval($perPage) +1
            );
        
    }
    public function findAll(){
        return Movie::all();
    }
    public function findOne($id){
        return Movie::find($id);
    }

    public function search($searchParam){
        return  Movie::where('title', $searchParam)->get();
    }

    public function count(){
        return Movie::count();
    }

}