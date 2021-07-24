<?php
function creationPanier(){
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier']=[];
        $_SESSION['panier']['id_produit']=[];
        $_SESSION['panier']['titre']=[];
        $_SESSION['panier']['photo']=[];
        $_SESSION['panier']['categorie']=[];
        $_SESSION['panier']['capacite']=[];
        $_SESSION['panier']['adresse']=[];
        $_SESSION['panier']['cp']=[];
        $_SESSION['panier']['ville']=[];
        $_SESSION['panier']['date_arrivee']=[];
        $_SESSION['panier']['heure_arrivee']=[];
        $_SESSION['panier']['date_depart']=[];
        $_SESSION['panier']['heure_depart']=[];
        $_SESSION['panier']['prix']=[];
    }
}
function ajouterProduitDansPanier($id_produit, $titre, $photo, $categorie, $capacite, $adresse, $cp, $ville, $date_arrivee, $heure_arrivee, $date_depart, $heure_depart, $prix){
    creationPanier();

    $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);

    if($position_produit !== false){
        $_SESSION['panier']['id_produit']==false;
        $_SESSION['panier']['titre']==false;
        $_SESSION['panier']['photo']==false;
        $_SESSION['panier']['categorie']==false;
        $_SESSION['panier']['capacite']==false;
        $_SESSION['panier']['adresse']==false;
        $_SESSION['panier']['cp']==false;
        $_SESSION['panier']['ville']==false;
        $_SESSION['panier']['date_arrivee']==false;
        $_SESSION['panier']['heure_arrivee']==false;
        $_SESSION['panier']['date_depart']==false;
        $_SESSION['panier']['heure_depart']==false;
        $_SESSION['panier']['prix']==false;
    }else{

        $_SESSION['panier']['id_produit'][]= $id_produit;
        $_SESSION['panier']['titre'][]= $titre;
        $_SESSION['panier']['photo'][]=$photo;
        $_SESSION['panier']['categorie'][]=$categorie;
        $_SESSION['panier']['capacite'][]=$capacite;
        $_SESSION['panier']['adresse'][]=$adresse;
        $_SESSION['panier']['cp'][]=$cp;
        $_SESSION['panier']['ville'][]=$ville;
        $_SESSION['panier']['date_arrivee'][]=$date_arrivee;
        $_SESSION['panier']['heure_arrivee'][]=$heure_arrivee;
        $_SESSION['panier']['date_depart'][]=$date_depart;
        $_SESSION['panier']['heure_depart'][]=$heure_depart;
        $_SESSION['panier']['prix'][]=$prix;
    }
}

function montantTotal(){
    $total = 0;
   for ($i=0; $i < count($_SESSION['panier']['id_produit']) ; $i++) { 
       $total += $_SESSION['panier']['prix'][$i];
   }
   return round($total, 2);
}

function internauteEstConnecte(){
    if(isset($_SESSION['membre'])){
        return true;
    }else{
        return false;
    }
}

function internauteConnecteEstAdmin(){
    if(internauteEstConnecte() AND $_SESSION['membre']['status']==1){
        return true;
    }else{
        return false;
    }
}