<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RelatedMovieRequest;
use App\Http\Requests\AddMovieRequest;
use App\Http\Requests\SearchMovieRequest;
use App\Movie;
use App\Services\MovieService;

class MovieController extends Controller
{
    private $movieService;
    public function __construct(MovieService $service){
        $this->movieService = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRelatedMovies(RelatedMovieRequest $request, $movieId){
        $data = $request->validated();
        return $this->movieService->findRelatedMovies($movieId, $data['numOfMovies']);
    }
    public function getPopularMovies(){
        $data=request(['numOfMovies']);
        return $this->movieService->findPopularMovies($data['numOfMovies']);
    }
    
    public function index()
    {
        
        if (!empty(request(['page'])) and !empty(request(['perPage'])) ){
            $genres = null;
            if (!empty(request(['genreFilter']))){
                $genreFilter = request(['genreFilter']);
                $genres = explode(',', $genreFilter['genreFilter']);
            }
            return $this->movieService->getAllMoviesByPage(intval(request(['page'])['page']), intval(request(['perPage'])['perPage']), $genres);

            
        }
        return $this->movieService->findAll();

        
    }

    public function count(){
        return $this->movieService->count();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddMovieRequest $request)
    {
        $data = $request->validated();
        return $this->movieService->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->movieService->findOne($id);
    }
        
    public function search(SearchMovieRequest $request){
        $data = request(['searchParam']);
        info($data['searchParam']);
        return  $this->movieService->search($data['searchParam']);
    }


    public function increaseVisits($movieId){
        $movie = Movie::find($movieId);
        $movie->num_of_visits = $movie->num_of_visits + 1;
        $movie->save();
        return $movie;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
