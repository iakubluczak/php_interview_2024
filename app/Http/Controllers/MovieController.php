<?php

namespace App\Http\Controllers;

use App\Services\Movies\MovieServiceFacade;
use App\Services\Movies\FooMovieService;
use App\Services\Movies\BarMovieService;
use App\Services\Movies\BazMovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieServiceFacade $movieServiceFacade;

    public function __construct()
    {
        $this->movieServiceFacade = new MovieServiceFacade([
            new FooMovieService(),
            new BarMovieService(),
            new BazMovieService(),
        ]);
    }

    public function getTitles(): JsonResponse
    {
        try {
            $titles = $this->movieServiceFacade->getAllTitles();
            return response()->json($titles);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure'], 503);
        }
    }
}
