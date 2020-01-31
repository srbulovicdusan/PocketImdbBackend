<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Genre;
use App\Services\GenreService;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    private $genreService;
    public function __construct(GenreService $service){
        $this->genreService = $service;
    }
    public function index(){
        return $this->genreService->findAll();
    }
}
