<?php
namespace App\Services;

use App\Events\MovieCreated;
use App\Movie;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Genre;
use App\MovieImage;
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
        return  Movie::where('title', $searchParam)->with('reactions')->with('image')->get();
    }
    public function elasticSearch($searchParam){
        $movies= Movie::complexSearch(array(
            'body' => array(
                'query' => array(
                    'match' => array(
                        'title' => $searchParam,
                    )   
                )
            )
        ));
        return $movies;
    }


    public function count(){
        return Movie::count();
    }
    public function create($movie){
        
        $savedImage = null;
        $genre = $movie['genre'];
        $genreDB = Genre::where('name', strtolower($genre))->first();
        if ($genreDB == null){
            $genreDB = Genre::create([
                'name' => strtolower($genre),
            ]);
        }
        if (!empty($movie['image'])){
            $image = $movie['image'];
            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $destinationFullSize = storage_path('app/public/fullSize').'/'.$image_name;
            $destinationThumbnail = storage_path('app/public/thumbnail').'/'.$image_name;

            $createdImage= Image::make($image->getRealPath());

            $createdImage->resize(400, 400, function($constraint){
            $constraint->aspectRatio();
            })->save($destinationFullSize);

            $createdImage->resize(200, 200, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationThumbnail);

            $savedImage = MovieImage::create([
                'fullSize' => url('storage/fullSize/'.$image_name),
                'thumbnail' => url('storage/thumbnail/'.$image_name)
            ]);
        }else if ($movie['image_url']){ //this is used when creating movie from OMDB
            $savedImage = MovieImage::create([
                'fullSize' => $movie['image_url'],
                'thumbnail' => $movie['image_url'],
            ]);
        }
        $movie = Movie::create([
            'title' => $movie['title'],
            'description' => $movie['description'],
            'num_of_visits' => 0,
            'genre_id' => $genreDB->id,
        ]);
        $movie->image()->associate($savedImage);
        $movie->save();
        $movie->addToIndex();
        event(new MovieCreated($movie));
        return $movie;

    }

}