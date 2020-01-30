<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(){
        return Genre::all();
    }
}
