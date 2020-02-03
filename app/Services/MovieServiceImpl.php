<?php
namespace App\Services;
use App\Movie;
class MovieServiceImpl implements MovieService{
    public function getAllMoviesByPage($page, $perPage, $genres){
        if ($genres != null && count($genres) != 0){
            $movies =  Movie::whereIn('genre_id', $genres)->get();
                $movies = $movies->toArray();
                $moviesByPage = array_chunk($movies, $perPage)[$page];
                return array(
                    'movies' => $moviesByPage,
                    'page' => $page,
                    'perPage' => $perPage,
                    'totalPages' => count($movies) % intval($perPage) == 0 ? count($movies) / intval($perPage) : intval(count($movies) / intval($perPage)) +1
                );
        }else{
            //info(Movie::offset($page * $perPage)->take($perPage)->get());
            //return Movie::offset($page * $perPage)->take($perPage)->get();
            return array(
                'movies' => Movie::offset($page * $perPage)->take($perPage)->get(),
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => Movie::all()->count() % intval($perPage) == 0 ? Movie::all()->count() / intval($perPage) : Movie::all()->count() / intval($perPage) +1
            );
        }
        
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
    public function create($movie){
        info($movie['description']);
        return Movie::create([
            'title' => $movie['title'],
            'description' => $movie['description'],
            'image_url' => $movie['image_url'],
            'num_of_visits' => 0,
            'genre_id' => $movie['genre_id'],
        ]);
    }

}