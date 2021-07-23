<?php include("inc/init.inc.php"); ?>
<?php include("inc/haut.inc.php"); ?>
<?php

if(isset($_GET['action']) && $_GET['action']=="deconnexion"){
    session_destroy();
     header('Location:'.RACINE_SITE.'reservation.php');
     ob_end_flush();
  }
  elseif(internauteEstConnecte()){
    header('Location:'.RACINE_SITE.'profil.php');
    ob_end_flush();
  }

if(!empty($_POST)){

    $membre = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");


    if($membre->rowCount()>0){
        
        $resultat = $membre->fetch(PDO::FETCH_ASSOC);


        if($_POST['mdp']== $resultat['mdp']){

            $_SESSION['membre']['id_membre']=$resultat['id_membre'];
            $_SESSION['membre']['prenom']=$resultat['prenom'];
            $_SESSION['membre']['nom']=$resultat['nom'];
            $_SESSION['membre']['pseudo']=$resultat['pseudo'];
            $_SESSION['membre']['email']= $resultat['email'];
            $_SESSION['membre']['civilite']=$resultat['civilite'];
            $_SESSION['membre']['date_enregistrement']=$resultat['date_enregistrement'];
            $_SESSION['membre']['status']=$resultat['status'];

            header('Location:'.RACINE_SITE.'profil.php');
            ob_end_flush();
        }else{
            echo '<div class="alert alert-warning text-center" role="alert">Veillez entrez le mdp correct</div>';
        }
    }else{
        echo '<div class="alert alert-info text-center" role="alert">Veillez vous incrire</div>';
    }
}
?>
<div style='height:800px' class='p-5 text-center'>
    <p class='fs-4'>Entrez vos données:</p>
        <form method="post" action="" style="color:gray; border-color:gray">
            <div class="form-group">
                <label for="pseudo">Pseudo</label><br>
                <input type="text" id="pseudo" name="pseudo"><br> <br>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label><br>
                <input type="password" id="mdp" name="mdp"><br><br>
            </div>
                <input class="btn btn-primary" type="submit" value="Se connecter">
        </form>
</div>
<?php include("inc/bas.inc.php"); ?>