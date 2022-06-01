<?php

namespace App\Http\Controllers;
use Session;
use App\Http\Controllers\Auth;
//use Illuminate\Http\Request;
use Validator;
use Exception;
use Request;
use App\Models\Manga;
use App\Models\Dessinateur;
use App\Models\Scenariste;
use App\Models\Genre;
class MangaController extends Controller
{
    /**
     * Affiche la liste de tous les mangas
     * @return Vue listerMangas
     */
    public function getMangas(){
        $erreur = Session::get('erreur');
       Session::forget('erreur');
        //On récupère la liste de tous les mangas
        $mangas = Manga::all();
          //On affiche la liste de ces mangas
        return view('listeMangas', compact('mangas', 'erreur'));
    }
    /**
     * Afficher la liste des tous les mangas d'un genre 
     * @param int $idGenre Id du genre
     * @return Vue listerMangas
     */
   /** public function getMangasGenre($idGenre){
      *  //on récupère de tous les mangas du genre choisi
        *$mangas = Manga::where('id_genre',$idGenre)->get();
       * //affiche la liste de ces mangas
       * return view('listeMangas', compact('mangas'));
   * }
    *  ----------------------------------------
    */
  
    public function getMangasGenre(){
       $erreur = Session::get('erreur');
      Session::forget('erreur');
        //On récupère l'id du genre sélectionné
       
        $id_genre = Request::input('cbGenre');
        
        //si on a un id de genre
        if($id_genre){
            // On récupère la liste de tous les mangas du genre choisi 
            $mangas = Manga::where('id_genre', $id_genre)->get();
            // On affiche la liste de ces mangas 
            return view('listeMangas', compact('mangas', 'erreur'));
        }
        
         else {   
            
        
      //  
            $erreur = "Il faut sélectionner un genre !";
            Session::put('erreur',$erreur);
           
            return redirect('/listerGenres');
        }     
    }
    /**
     * Formulaire de modification d'un Manga, Initialise toutes les listes déroulantes, Lit le manga à modifier, @param int $id Id du Manga à modifier
     * @param string $erreur message d'erreur (paramètre optionnel), @return Vue formManga
     */
    public function updateManga($id){
        //pour gerer les messages d'erreur depuis exceptions 
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $manga = Manga::find($id);
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Modification d'un Manga";
        //Affiche le formulaire en lui fournissant les données à afficher 
        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur'));
    }
    public function validateManga(Request $request){
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        //Recupération des valeurs saisis 
        $id_manga = Request::input('id_manga');//id dans le champs caché
        
        //---------------------------------
       
        //Liste des champs à vérifier 
        $regles = array(
            'titre' => 'required',
            'prix' => 'required | numeric',
            'cbScenariste'=> 'required',
            'cbGenre'=> 'required',
            'cbDessinateur' => 'required'
            );
        //Messages d'erreur personnalisés
           $messages = array(
            'titre.required' => 'Il faut saisir un titre',
            'cbGenre.required' => 'Il faut sélectionner un genre.',
            'cbScenariste.required'=> 'Il faut sélectionner un scénariste.',
            'cbDessinateur.required' => 'Il faut sélectionner un dessinateur.',
             'prix.required' => 'Il faut saisir un prix.',
             'prix.numeric' => 'Le prix doit être une valeur numérique' 
            );
        //Validation des champs 
        $validator = Validator::make(Request::all(), $regles, $messages);
        // on retourne au formulaire s'il y a un problème 
        if($validator->fails()){
            if($id_manga > 0){
                return redirect('modifierManga/' .$id_manga)
                        ->withErrors($validator)
                        ->withInput();
            }else{
                return redirect('ajouterManga/')
                         ->withErrors($validator)
                         ->withInput();
            }
        }
       //$id_dessinateur = Request::input('cbDessinateur');//Liste déroulante
        //--------------------
        //On récupère l'id du genre sélectionné
     // $id_dessinateur = Request::input('cbDessinateur');
        //si on a un id de dessinateur
      
            // On récupère la liste de tous les mangas du genre 
          //  $mangas = Manga::where('$id_dessinateur', $id_dessinateur)->get();
            // On affiche la liste de ces mangas       
      
        //--------------------
        $id_dessinateur = Request::input('cbDessinateur');// Liste déroulante
        $prix = Request::input('prix'); 
        
        $id_scenariste = Request::input('cbScenariste'); //Liste déroulante
        $titre =  Request::input('titre');
        $id_genre = Request::input('cbGenre');// Liste déroulante
        //--------------------------------
         //Récupération des valeurs saisies 
        //--------------------
         //Si on a uploadé une image, il faut la auvegarder
        //Sinon on a récupère le nom dans le champ caché 
        if(Request::hasFile('couverture')){
            $image = Request::file('couverture');
            $couverture = $image->getClientOriginalName();
            Request::file('couverture')->move(base_path() . '/public/images/', $couverture);      
        }else{
            $couverture = Request::input('couvertureHiden');
        }
        $manga = Manga::find($id_manga);
        //Si id_manga est>0 il faut lire le Manga existant, sinon il faut créer une instance de Manga
        if($id_manga >0) {
            $manga = Manga::find($id_manga);
        }else{
            $manga =new Manga();
        }
         $manga->titre = $titre;
         $manga->couverture = $couverture;
         $manga->prix = $prix;
         $manga->id_dessinateur = $id_dessinateur;
         $manga->id_scenariste = $id_scenariste;
          //-----on simule une erreur 
         $manga->id_genre = $id_genre;
        $manga->id_lecteur =1; //pour tester la modification 
         //$manga->id_genre = null;
        // $erreur = "";
        
        
        
        
         try{
             $manga->save();
         } catch (Exception $ex) {
              $erreur = $ex->getMessage();
              Session::put('erreur',$erreur);
              if($id_manga>0){
              return redirect('/modifierManga' .$id_manga);
              }else{
                  return redirect('/ajouterManga/');
              }
         }
         //on réaffiche la liste des mangas
         return redirect('/listerMangas');
    }
    /**
     * Formulaire d'ajout d'un Manga, Iniatialise toutes les listes déroulantes et place le formulaire formManga en mode ajout, @param string $erreur message d'erreur 
     * (paramètre optionnel) 
     */
    public function addManga(){
        //gestion des erreurs par sessions 
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $manga = new Manga();
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Ajout d'un Manga";
        //Affiche le formulaire en lui fournisant les données à afficher 
        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur'));
    }
    /**
     * Formulaire de suppression d'un Manga
     */
    public function deleteManga($id_manga){
       $erreur = Session::get('erreur');
        Session::forget('erreur');        
        //Si id_manga est>0 il faut lire le Manga existant, sinon il faut créer une instance de Manga
        if($id_manga >0) {
          //  $manga =new Manga();
            $manga = Manga::find($id_manga);
            $manga->delete();
        }
   
        //On récupère la liste de tous les mangas
        $mangas = Manga::all();
          //On affiche la liste de ces mangas
        return view('listeMangas', compact('mangas','erreur'));
    }
    
           
}
