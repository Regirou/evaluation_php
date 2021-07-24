<?php include("../inc/init.inc.php"); ?>
<?php include("../inc/haut.inc.php"); ?>

<?php
if(empty($_POST) AND !isset($_GET['choix'])){
?>
<div style="height: 800px">
    <p class="text-center pt-5 mt-5"><img src="<?php echo RACINE_SITE; ?>inc/img/membre.png" alt="" class="width25"></p>
    <p class="fs-4 pt-4 text-center">Cliquez sur les boutons pour ajouter un membre ou afficher des membres</p>
    <div class="d-flex my-5 justify-content-around">
        <a class='btn btn-primary' href="?choix=ajouter">Ajouter un membre</a>
        <a class='btn btn-primary' href="?choix=afficher">Afficher un membre</a>
    </div>
</div>

<?php
}else{
if(!empty($_POST)){

    foreach($_POST as $cle => $valeur){
        $_POST[$cle]=addSlashes($valeur);
    }
    if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
            $pdo->exec("UPDATE membre SET pseudo='$_POST[pseudo]', mdp='$_POST[mdp]',nom='$_POST[nom]',prenom='$_POST[prenom]',email='$_POST[email]',civilite='$_POST[civilite]',date_enregistrement='$_POST[date_enregistrement]',status='$_POST[status]' WHERE id_membre='$_GET[id]'");
            header('Location:'.RACINE_SITE.'admin/gestion_membre.php?choix=afficher');
            ob_end_flush();
    }else{
        $pdo->exec("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, date_enregistrement, status) VALUES ('$_POST[pseudo]','$_POST[mdp]','$_POST[nom]','$_POST[prenom]','$_POST[email]','$_POST[civilite]', '$_POST[date_enregistrement]','$_POST[status]')");
        header('Location:'.RACINE_SITE.'admin/gestion_membre.php?choix=afficher');
        ob_end_flush();
    }
}

if(isset($_GET['choix']) AND $_GET['choix']=='ajouter'){

?>
<div class='h-100 text-center'>
 <p class="fs-3 pt-5"> Formulaire Membres </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_membre" name="id_membre" />

        <div class="form-group">
        <label for="pseudo">Pseudo</label><br>
        <input class="form-control" type="text" id="pseudo" name="pseudo" placeholder="le pseudo du membre" /> <br><br>
        </div>

        <div class="form-group">
        <label for="mdp">Mot de passe</label><br>
        <input class="form-control" type="password" name="mdp" id="mdp" placeholder="le mot de passe du membre"/><br><br>
        </div>

        <div class="form-group">
        <label for="nom">Nom</label><br>
        <input class="form-control" type="text" id="nom" name="nom" placeholder="le nom du membre" /> <br><br>
        </div>

        <div class="form-group">
        <label for="prenom">Prenom</label><br>
        <input class="form-control" type="text" id="prenom" name="prenom" placeholder="le prenom du membre" /> <br><br>
        </div>

        <div class="form-group">
        <label for="email">E-mail</label><br>
        <input class="form-control" type="email" id="email" name="email" placeholder="l'e-mail du membre" /> <br><br>
        </div>

        <div class="form-group">
        <label for="civilite">Civilité</label><br>
        <select style="color:grey" class="form-control" name="civilite">
            <option value="Mme">Mme</option>
            <option value="Mlle">Mlle</option>
            <option value="Mr">Mr</option>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="date_enregistrement">Date d'enregistrement</label><br>
        <input style="color:grey" class="form-control" type="date" id="date_enregistrement" name="date_enregistrement"><br><br>
        </div>

        <div class="form-group">
        <label for="status">Status</label><br>
        <input class="form-control" type="integer" id="status" name="status" placeholder="le status du membre"><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="Ajouter un membre"/>
    </form>
</div>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='afficher'){
    $resultat = $pdo->query("SELECT * FROM membre");
?>
    <div style='height:800px' class='text-center p-5'>
    <table class="table table-striped table-responsive">
    <tr class="align-middle">
        <th>Pseudo</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>E-mail</th>
        <th>Civilité</th>
        <th>Date d'enregistrement</th>
        <th>Status</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>
<?php
    while($membres = $resultat->fetch(PDO::FETCH_ASSOC)){
        echo "<tr class='align-middle'>
        <td>$membres[pseudo]</td>
        <td>$membres[nom]</td>
        <td>$membres[prenom]</td>
        <td>$membres[email]</td>
        <td>$membres[civilite]</td>
        <td>$membres[date_enregistrement]</td>
        <td>$membres[status]</td>
        <td><a href='?choix=modifier&id=$membres[id_membre]'><img src='../inc/img/edit-button.png' height=25></td>
        <td><a href='?choix=supprimer&id=$membres[id_membre]'><img src='../inc/img/trash.png' height=25></a></td>
        </tr>";
    }
    echo "</table>";
?>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='supprimer'){
    $pdo->query("DELETE FROM membre WHERE id_membre='$_GET[id]'");
    header('Location:'.RACINE_SITE.'admin/gestion_membre.php?choix=afficher');
    ob_end_flush();
}
?>
<?php
if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    $resultat=$pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id]'");
    $membre_actuel=$resultat->fetch(PDO::FETCH_ASSOC);
?>
<div class='h-100 text-center'>
  <p class="fs-3 pt-3"> Formulaire Membres </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_membre" name="id_membre" />

        <div class="form-group">
        <label for="pseudo">Pseudo</label><br>
        <input class="form-control" type="text" id="pseudo" name="pseudo" placeholder="le pseudo du membre" value="<?php if(isset($membre_actuel['pseudo'])) echo $membre_actuel['pseudo']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="mdp">Mot de passe</label><br>
        <input class="form-control" type="password" name="mdp" id="mdp" placeholder="le mot de passe du membre" value="<?php if(isset($membre_actuel['mdp'])) echo $membre_actuel['mdp']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="nom">Nom</label><br>
        <input class="form-control" type="text" id="nom" name="nom" placeholder="le nom du membre" value="<?php if(isset($membre_actuel['nom'])) echo $membre_actuel['nom']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="prenom">Prenom</label><br>
        <input class="form-control" type="text" id="prenom" name="prenom" placeholder="le prenom du membre" value="<?php if(isset($membre_actuel['prenom'])) echo $membre_actuel['prenom']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="email">E-mail</label><br>
        <input class="form-control" type="email" id="email" name="email" placeholder="l'e-mail du membre" value="<?php if(isset($membre_actuel['email'])) echo $membre_actuel['email']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="civilite">Civilité</label><br>
        <select class="form-control" name="civilite">
            <option <?php if(isset($membre_actuel['civilite']) AND $membre_actuel['civilite']=='Mme') echo 'selected'; ?>>Mme</option>
            <option <?php if(isset($membre_actuel['civilite']) AND $membre_actuel['civilite']=='Mlle') echo 'selected'; ?>>Mlle</option>
            <option <?php if(isset($membre_actuel['civilite']) AND $membre_actuel['civilite']=='Mr') echo 'selected'; ?>>Mr</option>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="date_enregistrement">Date d'enregistrement</label><br>
        <input class="form-control" type="date" id="date_enregistrement" name="date_enregistrement" value="<?php if(isset($membre_actuel['date_enregistrement'])) echo $membre_actuel['date_enregistrement']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="status">Status</label><br>
        <input class="form-control" type="integer" id="status" name="status" placeholder="le status du membre" value="<?php if(isset($membre_actuel['status'])) echo $membre_actuel['status']; ?>"/><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="Modifier un membre"/>
    </form>
<?php
}
}
?>

<?php include("../inc/bas.inc.php"); ?>