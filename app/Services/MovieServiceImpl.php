<?php
namespace App\Services;

use App\Events\MovieCreated;
use App\Movie;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

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
                    'totalPages' =>  count($movies)/ intval($perPage),
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
        return Movie::with('reactions')->where('genre_id', $movie->genre_id)->where('id', '!=', $movie->id)->with('reactions')->take($numOfMovies)->get();
    }

    public function findPopularMovies($numOfMovies){
        return Movie::with('reactions')->whereHas('reactions', function (Builder $query) {
            $query->where('type', 'like', 'LIKE');
        })->get()->sortByDesc(function($movie, $id){
            return count($movie['reactions']->where('type', 'LIKE'));
        })->values()->take($numOfMovies);
    }
    public function findAll(){
        return Movie::all();
    }
    public function findOne($id){
        return Movie::find($id)->load('reactions');
    }

    public function search($searchParam){
        return  Movie::where('title', $searchParam)->with('reactions')->get();
    }

    public function count(){
        return Movie::count();
    }
    public function create($movie){
        $movie =  Movie::create([
            'title' => $movie['title'],
            'description' => $movie['description'],
            'image_url' => $movie['image_url'],
            'num_of_visits' => 0,
            'genre_id' => $movie['genre_id'],
        ]);
        event(new MovieCreated($movie));
        return $movie;

    }

}