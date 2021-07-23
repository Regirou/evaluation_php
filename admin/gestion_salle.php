<?php include("../inc/init.inc.php"); ?>
<?php include("../inc/haut.inc.php"); ?>

<?php
if(empty($_POST) AND !isset($_GET['choix'])){
?>
<div style="height: 800px">
    <p class="text-center pt-5"><img src="<?php echo RACINE_SITE; ?>inc/img/Cosy.jpeg" alt="" class="width25"></p>
    <p class="fs-4 pt-4 text-center">Cliquez sur les boutons pour ajouter une salle ou afficher des salles</p>
    <div class="d-flex my-5 justify-content-around">
        <a class='btn btn-primary' href="?choix=ajouter">Ajouter une salle</a>
        <a class='btn btn-primary' href="?choix=afficher">Afficher une salle</a>
    </div>
</div>

<?php
}else{
if(!empty($_POST)){

    $photo_bdd = '';
    if(!empty($_FILES['photo']['name'])){

        $nom_photo=$_POST['titre'].'_'.$_FILES['photo']['name'];
        $photo_bdd = RACINE_SITE ."photo/$nom_photo";
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'].RACINE_SITE."photo/$nom_photo";
        copy($_FILES['photo']['tmp_name'], $photo_dossier);
    }

    foreach($_POST as $cle => $valeur){
        $_POST[$cle]=addSlashes($valeur);
    }

    if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){

        if(!isset($_GET['id']) AND empty($_FILES['photo']['name'])){
            $pdo->exec("UPDATE salle SET titre='$_POST[titre]', description='$_POST[description]',pays='$_POST[pays]',ville='$_POST[ville]',adresse='$_POST[adresse]',cp='$_POST[cp]',capacite='$_POST[capacite]',categorie='$_POST[categorie]' WHERE id_salle='$_GET[id]'");
            header('Location:'.RACINE_SITE.'admin/gestion_salle.php?choix=afficher'); 
            ob_end_flush();
        }else{
            $pdo->exec("UPDATE salle SET titre='$_POST[titre]', description='$_POST[description]',pays='$_POST[pays]',ville='$_POST[ville]',adresse='$_POST[adresse]',cp='$_POST[cp]',capacite='$_POST[capacite]',categorie='$_POST[categorie]' WHERE id_salle='$_GET[id]'");
            header('Location:'.RACINE_SITE.'admin/gestion_salle.php?choix=afficher');
            ob_end_flush();
        }
    }else{
        $pdo->exec("INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie) VALUES ('$_POST[titre]','$_POST[description]','$photo_bdd','$_POST[pays]','$_POST[ville]','$_POST[adresse]', '$_POST[cp]', '$_POST[capacite]','$_POST[categorie]')");
        header('Location:'.RACINE_SITE.'admin/gestion_salle.php?choix=afficher'); 
        ob_end_flush();
    }
}

if(isset($_GET['choix']) AND $_GET['choix']=='ajouter'){

?>
<div class='h-100 text-center'>
<p class="fs-3 pt-5"> Formulaire Salles <p>

    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_salle" name="id_salle" />

        <div class="form-group">
        <label for="titre">Titre</label><br>
        <input class="form-control" type="text" id="titre" name="titre" placeholder="le titre de la salle" /> <br><br>
        </div>

        <div class="form-group">
        <label for="description">Description</label><br>
        <textarea class="form-control" name="description" id="description" placeholder="la description du produit"></textarea><br><br>
        </div>

        <div class="form-group">
        <label for="photo">Photo</label><br>
        <input class="form-control" type="file" id="photo" name="photo"><br><br>
        </div>

        <div class="form-group">
        <label for="pays">Pays</label><br>
        <input class="form-control" type="text" id="pays" name="pays" placeholder="le pays de la salle" /> <br><br>
        </div>

        <div class="form-group">
        <label for="ville">Ville</label><br>
        <input class="form-control" type="text" id="ville" name="ville" placeholder="la ville de la salle" /> <br><br>
        </div>

        <div class="form-group">
        <label for="adresse">Adresse</label><br>
        <input class="form-control" type="text" id="adresse" name="adresse" placeholder="l'adresse de la salle" /> <br><br>
        </div>

        <div class="form-group">
        <label for="cp">Code postal</label><br>
        <input class="form-control" type="integer" id="cp" name="cp" placeholder="le code postal de la salle"><br><br>
        </div>

        <div class="form-group">
        <label for="capacite">Capacité</label><br>
        <input class="form-control" type="integer" id="capacite" name="capacite" placeholder="la capacité de la salle"><br><br>
        </div>

        <div class="form-group">
        <label for="categorie">Catégorie</label><br>
        <select class="form-control" name="categorie">
            <option value="reunion">Réunion</option>
            <option value="bureau">Bureau</option>
            <option value="formation">Formation</option>
        </select><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="ajouter une salle"/>
    </form>
</div>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='afficher'){
    $resultat = $pdo->query("SELECT * FROM salle");
    ?>
    <div class='text-center p-5'>
    <table class="table table-striped">
    <tr class="align-middle">
    <th>ID de la salle</th>
    <th>Titre</th>
    <th>Description</th>
    <th>Photo</th>
    <th>Pays</th>
    <th>Ville</th>
    <th>Adresse</th>
    <th>Code postal</th>
    <th>Capacité</th>
    <th>Catégorie</th>
    <th>Modifier</th>
    <th>Supprimer</th>
    </tr>
<?php
    while($salles = $resultat->fetch(PDO::FETCH_ASSOC)){
        echo "<tr class='align-middle'>
        <td>$salles[id_salle]</td>
        <td>$salles[titre]</td>
        <td>$salles[description]</td>
        <td><img src='$salles[photo]' height=70>
        </td><td>$salles[pays]</td>
        <td>$salles[ville]</td>
        <td>$salles[adresse]</td>
        <td>$salles[cp]</td>
        <td>$salles[capacite]</td>
        <td>$salles[categorie]</td>
        <td><a href='?choix=modifier&id=$salles[id_salle]'><img src='../inc/img/edit-button.png' height=25></td>
        <td><a href='?choix=supprimer&id=$salles[id_salle]'><img src='../inc/img/trash.png' height=25></a></td>
        </tr>";
    }
    echo "</table>
    </div>";
?>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='supprimer'){
    $resultat=$pdo->query("SELECT * FROM salle WHERE id_salle='$_GET[id]'");
    $salle_a_supprimer=$resultat->fetch(PDO::FETCH_ASSOC);
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'].$salle_a_supprimer['photo'];

    if(!empty($salle_a_supprimer) AND file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    $pdo->query("DELETE FROM salle WHERE id_salle='$_GET[id]'");
}
?>
<?php
if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    $resultat=$pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[id]'");
    $salle_actuel=$resultat->fetch(PDO::FETCH_ASSOC);
?>
<div class='h-100 text-center'>
  <p class="fs-3 pt-3"> Formulaire Salles </h1>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_salle" name="id_salle" />

        <div class="form-group">
        <label for="titre">Titre</label><br>
        <input class="form-control" type="text" id="titre" name="titre" placeholder="le titre de la salle" value="<?php if(isset($salle_actuel['titre'])) echo $salle_actuel['titre']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="description">Description</label><br>
        <textarea class="form-control" name="description" id="description" placeholder="la description du produit"><?php if(isset($salle_actuel['description'])) echo $salle_actuel['description']; ?></textarea><br><br>
        </div>

        <div class="form-group">
        <label for="photo">Photo</label><br>
        <input class="form-control" type="file" id="photo" name="photo" value= "" <?php if(isset($salle_actuel['photo'])) echo $salle_actuel['photo']; ?>><br><br>
        <img src="<?php if(isset($salle_actuel['photo'])) echo $salle_actuel['photo']; ?> " class='width25'><br><br>
        </div>

        <div class="form-group">
        <label for="pays">Pays</label><br>
        <input class="form-control" type="text" id="pays" name="pays" placeholder="le pays de la salle" value="<?php if(isset($salle_actuel['pays'])) echo $salle_actuel['pays']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="ville">Ville</label><br>
        <input class="form-control" type="text" id="ville" name="ville" placeholder="la ville de la salle" value="<?php if(isset($salle_actuel['ville'])) echo $salle_actuel['ville']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="adresse">Adresse</label><br>
        <input class="form-control" type="text" id="adresse" name="adresse" placeholder="l'adresse de la salle" value="<?php if(isset($salle_actuel['adresse'])) echo $salle_actuel['adresse']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="cp">Code postal</label><br>
        <input class="form-control" type="integer" id="cp" name="cp" placeholder="le code postal de la salle" value="<?php if(isset($salle_actuel['cp'])) echo $salle_actuel['cp']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="capacite">Capacité</label><br>
        <input class="form-control" type="integer" id="capacite" name="capacite" placeholder="la capacité de la salle" value="<?php if(isset($salle_actuel['capacite'])) echo $salle_actuel['capacite']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="categorie">Catégorie</label><br>
        <select class="form-control" name="categorie">
            <option <?php if(isset($salle_actuel['categorie']) AND $salle_actuel['categorie']=='reunion') echo 'selected'; ?>>Réunion</option>
            <option <?php if(isset($salle_actuel['categorie']) AND $salle_actuel['categorie']=='bureau') echo 'selected'; ?>>Bureau</option>
            <option <?php if(isset($salle_actuel['categorie']) AND $salle_actuel['categorie']=='formation') echo 'selected'; ?>>Formation</option>
        </select><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="modifier une salle"/>
    </form>

<?php
}
}
?>

<?php include("../inc/bas.inc.php"); ?>
