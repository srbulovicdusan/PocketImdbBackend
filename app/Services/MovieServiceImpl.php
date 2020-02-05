<?php
namespace App\Services;
use App\Movie;
use Illuminate\Database\Eloquent\Builder;
class MovieServiceImpl implements MovieService{
    public function getAllMoviesByPage($page, $perPage, $genres){
        if ($genres != null && count($genres) != 0){
            $movies =  Movie::whereIn('genre_id', $genres)->with('reactions')->get();
                $movies = $movies->toArray();
                $moviesByPage = array_chunk($movies, $perPage)[$page];
                return array(
                    'movies' => $moviesByPage,
                    'page' => $page,
                    'perPage' => $perPage,
                    'totalPages' =>  Movie::all()->count()/ intval($perPage),
                );
        }else{
            return array(
                'movies' => Movie::offset($page * $perPage)->take($perPage)->with('reactions')->get(),
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => Movie::all()->count()/ intval($perPage),
            );
        }
        
    }
    public function findRelatedMovies($movieId, $numOfMovies){
        $movie = Movie::find($movieId);
        return Movie::where('genre_id', $movie->genre_id)->where('id', '!=', $movie->id)->take($numOfMovies)->get();
    }

    public function findPopularMovies($numOfMovies){
        return Movie::whereHas('reactions', function (Builder $query) {
            $query->where('type', 'like', 'LIKE');
        })->get()->sortByDesc(function($movie, $id){
            return count($movie['reactions']->where('type', 'LIKE'));
        })->values()->take($numOfMovies);
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
        return Movie::create([
            'title' => $movie['title'],
            'description' => $movie['description'],
            'image_url' => $movie['image_url'],
            'num_of_visits' => 0,
            'genre_id' => $movie['genre_id'],
        ]);
    }

}