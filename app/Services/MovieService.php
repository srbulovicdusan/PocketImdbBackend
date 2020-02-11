<?php
namespace App\Services;
interface MovieService {
    public function getAllMoviesByPage($page, $perPage, $genres);

    public function findRelatedMovies($movieId, $numOfMovies);
    
    public function findPopularMovies($numOfMovies);

    public function findOne($id);

    public function search($searchParam);

    public function elasticSearch($searchParam);

    public function count();

    public function findAll();

    public function create($movie);
}