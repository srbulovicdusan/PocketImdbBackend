<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Services\MovieService;

class MovieController extends Controller
{

    public function __construct(MovieService $service){
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function filter(){
          if (!empty(request(['page'])) and !empty(request(['perPage'])) ){

            $data = request(['page', 'perPage']);
            if (empty(request(['genreFilter']))){
                return Movie::offset($data['page'] * $data['perPage'])->take($data['perPage'])->get();
            }else{
                $genreFilter = request(['genreFilter']);
                $genres = explode(',', $genreFilter['genreFilter']);
                $movies =  Movie::whereIn('genre_id', $genres)->get();
                $movies = $movies->toArray();
                $moviesByPage = array_chunk($movies, $data['perPage'])[$data['page']];
                info($moviesByPage);
                return $moviesByPage;
            }
          }
            return $this->service->findAll();

  }
    public function index()
    {
        
        if (!empty(request(['page'])) and !empty(request(['perPage'])) ){
            return $this->service->getAllMoviesByPage(intval(request(['page'])['page']), intval(request(['perPage'])['perPage']));
        }
        return $this->service->findAll();

        
    }

    public function count(){
        return $this->service->findAll();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->service->findOne($id);
    }
        
    public function search($searchParam){
        return  $this->service->search($searchParam);
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
