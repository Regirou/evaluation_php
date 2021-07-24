<?php include("../inc/init.inc.php"); ?>
<?php include("../inc/haut.inc.php"); ?>

<?php
if(empty($_POST) AND !isset($_GET['choix'])){
?>
<div style="height: 800px">
    <p class="text-center pt-5 mt-5"><img src="<?php echo RACINE_SITE; ?>inc/img/Cosy.jpeg" alt="" class="width25"></p>
    <p class="fs-4 pt-4 text-center">Cliquez sur les boutons pour ajouter un avis ou afficher des aviss</p>
    <div class="d-flex my-5 justify-content-around">
        <a class='btn btn-primary' href="?choix=ajouter">Ajouter un avis</a>
        <a class='btn btn-primary' href="?choix=afficher">Afficher un avis</a>
    </div>
</div>
<?php

// echo '<pre>'
// print_r($_POST);æ
// echo '<pre>';
}else{
if(!empty($_POST)){

    foreach($_POST as $cle => $valeur){
        $_POST[$cle]=addSlashes($valeur);
    }

    if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
            $pdo->exec("UPDATE avis SET id_membre='$_POST[id_membre]', id_salle='$_POST[id_salle]', commentaire='$_POST[commentaire]', note='$_POST[note]', date_enregistrement='$_POST[date_enregistrement]' WHERE id_avis='$_GET[id]'");
            header('Location:'.RACINE_SITE.'admin/gestion_avis.php?choix=afficher');
            ob_end_flush();
    }else{
        $pdo->exec("INSERT INTO avis(id_membre, id_salle, commentaire, note, date_enregistrement) VALUES ('$_POST[id_membre]','$_POST[id_salle]','$_POST[commentaire]', '$_POST[note]','$_POST[date_enregistrement]')");
        header('Location:'.RACINE_SITE.'admin/gestion_avis.php?choix=afficher');
        ob_end_flush();
    }
}

if(isset($_GET['choix']) AND $_GET['choix']=='ajouter'){

?>
<div class='text-center p-4'>
 <p class="fs-3"> Formulaire Avis </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_avis" name="id_avis" />

        <div class="form-group">
        <label for="id_membre">ID du membre</label><br>
        <select class="form-control" name="id_membre" style='color:grey'>
            <?php
            $resultat=$pdo->query("SELECT * FROM membre");

            while($membre=$resultat->fetch(PDO::FETCH_ASSOC)){

                echo "<option value='$membre[id_membre]'>$membre[id_membre] - $membre[nom] - $membre[prenom] - $membre[email]</option>";
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="id_salle">ID de la salle</label><br>
        <select class="form-control" name="id_salle" style='color:grey'>
            <?php
            $resultat2=$pdo->query("SELECT * FROM salle");

            while($salle=$resultat2->fetch(PDO::FETCH_ASSOC)){

                echo "<option value='$salle[id_salle]'>$salle[id_salle] - $salle[titre]</option>";
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="commentaire">Commentaire</label><br>
        <input class="form-control" type="text" name="commentaire" id="commentaire" placeholder="commentaire" style='color:grey'/><br><br>
        </div>

        <div class="form-group">
        <label for="note">Note</label><br>
        <select class="form-control" name="note" style='color:grey'>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="date_enregistrement">Date d'enrégistrement</label><br>
        <input class="form-control" type="date" name="date_enregistrement" id="date_enregistrement" placeholder="date_enregistrement" style='color:grey'/><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5"  type="submit" value="Ajouter un avis"/>
    </form>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='afficher'){
    $resultat3 = $pdo->query("SELECT * FROM avis 
    INNER JOIN salle ON avis.id_salle=salle.id_salle
    INNER JOIN membre ON avis.id_membre=membre.id_membre");
?>
<div style='height:800px' class='text-center p-5 table-responsive'>
<table class="table table-striped">
<tr class="align-middle">
    <th>ID de l'avis</th>
    <th>Membre</th>
    <th>ID de la salle</th>
    <th>Photo</th>
    <th>Commentaire</th>
    <th>Note</th>
    <th>Date d'enrégistrement</th>
    <th>Modifier</th>
    <th>Supprimer</th>
    </tr>
<?php
    while($avis = $resultat3->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
        <td>$avis[id_avis]</td>
        <td>$avis[id_membre] - $avis[pseudo] - $avis[email]</td>
        <td>$avis[id_salle]</td>
        <td><img src='$avis[photo]' height=70></td>
        <td>$avis[commentaire]</td>
        <td>$avis[note]</td>
        <td>$avis[date_enregistrement]</td>
        <td><a href='?choix=modifier&id=$avis[id_avis]'><img src='../inc/img/edit-button.png' height=25></td>
        <td><a href='?choix=supprimer&id=$avis[id_avis]'><img src='../inc/img/trash.png' height=25></a></td>
        </tr>";
    }
    echo "</table>";
?>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='supprimer'){
    $pdo->query("DELETE FROM avis WHERE id_avis='$_GET[id]'");
    header('Location:'.RACINE_SITE.'admin/gestion_avis.php?choix=afficher');
    ob_end_flush();
}
?>
<?php
if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    $resultat3=$pdo->query("SELECT * FROM avis WHERE id_avis = '$_GET[id]'");
    $avis_actuel=$resultat3->fetch(PDO::FETCH_ASSOC);

?>
<div class='h-100 text-center'>
  <p class="fs-3 pt-3"> Formulaire Avis </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_avis" name="id_avis" />

        <div class="form-group">
        <label for="id_membre">ID du membre</label><br>
        <select class="form-control" name="id_membre">
            <?php
            $resultat=$pdo->query("SELECT * FROM membre");
            while($membre=$resultat->fetch(PDO::FETCH_ASSOC)){
            ?>
                <option value="<?php echo $membre['id_membre']; ?>"<?php if(isset($avis_actuel['id_membre']) AND $avis_actuel['id_membre']==$membre['id_membre']) echo 'selected';?>><?php echo $membre['id_membre'].' - '.$membre['nom'].' - '.$membre['prenom'].' - '.$membre['email']?></option>
            <?php
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="id_salle">Salle</label><br>
        <select class="form-control" name="id_salle">
            <?php
            $res=$pdo->query("SELECT * FROM salle");
            
            while($salles=$res->fetch(PDO::FETCH_ASSOC))
            {
            ?>
                <option value="<?php echo $salles['id_salle']; ?>"<?php if(isset($avis_actuel['id_salle']) AND $avis_actuel['id_salle']==$salles['id_salle']) echo 'selected';?>><?php echo ($salles['id_salle'].' - '.$salles['titre']);?></option>
           <?php
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="commentaire">Commentaire</label><br>
        <input class="form-control" type="text" name="commentaire" id="commentaire" placeholder="commentaire" value="<?php if(isset($avis_actuel['commentaire'])) echo $avis_actuel['commentaire']; ?>"/><br><br>

        <div class="form-group">
        <label for="note">Note</label><br>
        <select class="form-control" class="form-control" name="note">
            <option <?php if(isset($avis_actuel['note']) AND $avis_actuel['note']=='1') echo 'selected'; ?>>1</option>
            <option <?php if(isset($avis_actuel['note']) AND $avis_actuel['note']=='2') echo 'selected'; ?>>2</option>
            <option <?php if(isset($avis_actuel['note']) AND $avis_actuel['note']=='3') echo 'selected'; ?>>3</option>
            <option <?php if(isset($avis_actuel['note']) AND $avis_actuel['note']=='4') echo 'selected'; ?>>4</option>
            <option <?php if(isset($avis_actuel['note']) AND $avis_actuel['note']=='5') echo 'selected'; ?>>5</option>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="date_enregistrement">Date d'enrégistrement</label><br>
        <input class="form-control" type="date" name="date_enregistrement" id="date_enregistrement" placeholder="date_enregistrement" value="<?php if(isset($avis_actuel['date_enregistrement'])) echo $avis_actuel['date_enregistrement']; ?>"/><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="Ajouter un avis"/>
    </form>
<?php
}
}
?>

<?php include("../inc/bas.inc.php"); ?>