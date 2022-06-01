<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\Http\Request;
use Session;

class GenreController extends Controller
{
    /**
     * Afficher les genres dans une liste déroulante
     * @return Vue formGenre
     */
    public function getGenres(){
                $erreur = Session::get('erreur');
        Session::forget('erreur');
        $genres = Genre::all();
        return view('formGenre', compact('genres', 'erreur'));
    }
}
