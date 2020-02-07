<?php
namespace App\Services;

use App\Movie;
use App\MovieImage;
use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\ImageManagerStatic as Image;

class MovieServiceImpl implements MovieService{
    public function getAllMoviesByPage($page, $perPage, $genres){
        if ($genres != null && count($genres) != 0){
            $movies =  Movie::whereIn('genre_id', $genres)->with('reactions', 'image')->get();
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
                'movies' => Movie::offset($page * $perPage)->take($perPage)->with('reactions', 'image')->get(),
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => Movie::all()->count()/ intval($perPage),
            );
        }
        
    }
    public function findRelatedMovies($movieId, $numOfMovies){
        $movie = Movie::find($movieId);
        return Movie::with('reactions', 'image')->where('genre_id', $movie->genre_id)->where('id', '!=', $movie->id)->with('reactions', 'image')->take($numOfMovies)->get();
    }

    public function findPopularMovies($numOfMovies){
        return Movie::with('reactions', 'image')->whereHas('reactions', function (Builder $query) {
            $query->where('type', 'like', 'LIKE');
        })->get()->sortByDesc(function($movie, $id){
            return count($movie['reactions']->where('type', 'LIKE'));
        })->values()->take($numOfMovies);
    }
    public function findAll(){
        return Movie::all();
    }
    public function findOne($id){
        return Movie::find($id)->load('reactions', 'image');
    }

    public function search($searchParam){
        return  Movie::where('title', $searchParam)->with('reactions')->get();
    }

    public function count(){
        return Movie::count();
    }
    public function create($movie){
        $image = $movie['image'];
        $savedImage = null;
        if ($image){
            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $destinationFullSize = public_path('storage/fullSize').'/'.$image_name;
            $destinationThumbnail = public_path('storage/thumbnail').'/'.$image_name;

            $createdImage= Image::make($image->getRealPath());

            $createdImage->resize(400, 400, function($constraint){
            $constraint->aspectRatio();
            })->save($destinationFullSize);

            $createdImage->resize(200, 200, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationThumbnail);

            $savedImage = MovieImage::create([
                'fullSize' => asset('storage/fullSize/'.$image_name),
                'thumbnail' => asset('storage/thumbnail/'.$image_name)

            ]);
        }else if ($movie['image_url']){ //this is used when creating movie from OMDB
            $savedImage = MovieImage::create([
                'fullSize' => $movie['image_url'],
                'thumbnail' => $movie['image_url'],

            ]);
        }else{
            abort(422, "Image not presented.");
        }
        return Movie::create([
            'title' => $movie['title'],
            'description' => $movie['description'],
            'num_of_visits' => 0,
            'genre_id' => $movie['genre_id'],
            'image_id' => $savedImage->id,
        ]);
        
    }

}