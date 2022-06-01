<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route par défaut
//Route::get('/', function () {
    //return view('home');
//});
Route::get('/', 'HomeController@index');
//afficher la liste de tous les mangas
Route::get('/listerMangas','MangaController@getMangas');
//Liste tous les mangas d'un genre sélectionné 
//Route::get('/listerMangasGenre/{idGenre}', 'MangaController@getMangasGenre');
//Lister tous les mangas d'un genre sélectionné
Route::post('/listerMangasGenre', 'MangaController@getMangasGenre');
// Afficher la liste déroulante des genres
Route::get('/listerGenres', 'GenreController@getGenres');
//Afficher un manga pour pouvoir éventuellement le modifier
Route::get('/modifierManga/{id}', 'MangaController@updateManga');
// Enregistrer la mise à jour d'un manga
Route::post('/validerManga', 'MangaController@validateManga');
//ajout manga
Route::get('/ajouterManga', 'MangaController@addManga');//->middleware('autorise');
//supprimer manga
Route::get('/supprimerManga/{id?}', 'MangaController@deleteManga');
//teste autorisation 
//Route::get('/listerMangasGenre','MangaController@getMangasGenre')->Autorisation('autorise');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profil', 'ProfilController@getProfil');
Route::post('/profil', 'ProfilController@setProfil');
