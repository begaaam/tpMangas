<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

use Validator;
//use Exception;
use App\User;
use Lecteur;
class ProfilController extends Controller
{
    public function getProfil(){
        $erreur = "";
        $user = Auth::user();
        $id_lecteur = $user->id;
        $lecteur = Lecteur::find($id_lecteur);
        return view('formProfil', compact('lecteur', 'user','erreur'));
    }
    
    public function setProfil(){
      //Message d'erreur personnalisés 
      $messages = array(
        'nom.required'=> 'Il faut saisir un nom .',
        'prenom.required'=> 'Il faut selectionner un prenom .',
        'cp.required'=> 'Il faut saisir le code postal.',
        'cp.required'=> 'Le code postal doit être une valeur numérique .'
     );
      //Liste des champs à verfier 
      $regles = array(
          'nom' => 'required',
          'prenom' => 'required',
          'cp' => 'required | numeric'
      );
      $validator = Validator::make(Request::all(), $regles, $messages);
      // On retourne au formulaire s'il y a un probleme
      if($validator->false()){
          return redirect('formProfil')
                         ->withErros($validator)
                         ->withInput();
      }
      // On récupère les données et on enregistre
      $user = Auth::user();
      $id_lecteur = $user->id;
      $lecteur = Lecteur::find($id_lecteur);
      $lecteur->nom = Request::input('nom');
      $lecteur->prenom = Request::input('prenom');
      $lecteur->rue = Request::input('rue');
      $lecteur->cp = Request::input('cp');
      $lecteur->ville = Request::input('ville');
       $lecteur->save();
       return redirect('/home');
      
    }
}
