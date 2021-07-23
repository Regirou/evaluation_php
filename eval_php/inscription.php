<?php include("inc/init.inc.php"); ?>
<?php include("inc/haut.inc.php"); ?>
<?php

if(!empty($_POST)){

    if (strlen($_POST['pseudo'])<6||strlen($_POST['pseudo']>20)){
        echo "<div class='alert alert-warning text-center' role='alert'> Votre pseudo trop court ou trop long</div>";
    }else{
        $membre = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
        $resultat = $membre->fetch(PDO::FETCH_ASSOC);
        if($membre->rowCount()>0){
            echo "<div class='alert alert-info text-center' role='alert'> Pseudo déja existant </div>";
        }else{
            $pdo->exec("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, date_enregistrement) VALUES('$_POST[pseudo]','$_POST[mdp]','$_POST[nom]','$_POST[prenom]','$_POST[email]', '$_POST[civilite]', curdate())");
            $res = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
                $membre = $res->fetch(PDO::FETCH_ASSOC);
                if($_POST['mdp']== $membre['mdp']){
                    $_SESSION['membre']['prenom']=$membre['prenom'];
                    $_SESSION['membre']['nom']=$membre['nom'];
                    $_SESSION['membre']['pseudo']=$membre['pseudo'];
                    $_SESSION['membre']['email']= $membre['email'];
                    $_SESSION['membre']['civilite']=$membre['civilite'];
                    header('Location: '.RACINE_SITE.'profil.php?');
                }
        }
    }

}
?>
<div class='h-100 p-5 text-center'>
<p class='fs-4'>Entrez vos données:</p>
<form method="post" action="" class="w-50 p-3 m-auto">

    <div class="form-group">
        <!-- <label for="pseudo">Pseudo</label><br> -->
        <input class="form-control" type="text" id="pseudo" name="pseudo" maxlength="20" pattern="[a-zA-Z0-9-_.]{6,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required" placeholder="Pseudo"><br><br>
    </div>
    <div class="form-group">
        <!-- <label for="mdp">Mot de passe</label><br> -->
        <input class="form-control" type="password" id="mdp" name="mdp" required="required" placeholder="Mot de passe"><br><br>
    </div>
    <div class="form-group">
        <!-- <label for="nom">Nom</label><br> -->
        <input class="form-control" type="text" id="nom" name="nom" placeholder="Nom"><br><br>
    </div>
    <div class="form-group">
        <!-- <label for="prenom">Prénom</label><br> -->
        <input class="form-control" type="text" id="prenom" name="prenom" placeholder="Prénom"><br><br>
    </div>
    <div class="form-group">
        <!-- <label for="email">Email</label><br> -->
        <input class="form-control" type="email" id="email" name="email" placeholder="exemple@gmail.com"><br><br>
    </div>
    <div class="form-group">
        <!-- <label for="civilite">Civilité</label><br> -->
        <select class="form-control" name="civilite" style="color:gray">
            <option value="mme">Mme</option>
            <option value="mlle">Mlle</option>
            <option value="mr">Mr</option>
        </select><br><br>
    </div>
    <input class="form-control btn btn-primary mb-5" type="submit" name="inscription" value="S'inscrire">
</form>


<?php include("inc/bas.inc.php"); ?>