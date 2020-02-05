<?php
namespace App\Services;
interface MovieService {
    public function getAllMoviesByPage($page, $perPage, $genres);

    public function storeOMDBMovie($movie);

    public function findOne($id);

    public function search($searchParam);

    public function count();

    public function findAll();

}