<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\MovieViewModel;
use App\ViewModels\MoviesViewModel;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popularMovies = Http::get('https://api.themoviedb.org/3/movie/popular?api_key='.config('services.tmdb.token').'&language=en-US&page=1')
            ->json()['results'];
            //print_r($popularMovies);exit;

        $nowPlayingMovies = Http::get('https://api.themoviedb.org/3/movie/now_playing?api_key='.config('services.tmdb.token').'&language=en-US&page=1')
            ->json()['results'];

        $genres = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key='.config('services.tmdb.token').'&language=en-US&page=1')
            ->json()['genres'];

        $viewModel = new MoviesViewModel(
            $popularMovies,
            $nowPlayingMovies,
            $genres,
        );

        return view('movies.index', $viewModel);
    }

   
    public function show($id)
    {
        $movie = Http::get('https://api.themoviedb.org/3/movie/'.$id.'?append_to_response=credits,videos,images&api_key='.config('services.tmdb.token').'&language=en-US&page=1')
            ->json();

        $viewModel = new MovieViewModel($movie);

        return view('movies.show', $viewModel);
    }

}
