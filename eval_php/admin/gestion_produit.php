<?php include("../inc/init.inc.php"); ?>
<?php include("../inc/haut.inc.php"); ?>

<?php
if(empty($_POST) AND !isset($_GET['choix'])){
?>
<div style="height: 800px">
    <p class="text-center pt-5 mt-5"><img src="<?php echo RACINE_SITE; ?>inc/img/Cosy.jpeg" alt="" class="width25"></p>
    <p class="fs-4 pt-4 text-center">Cliquez sur les boutons pour ajouter un produit ou afficher des produits</p>
    <div class="d-flex my-5 justify-content-around">
        <a class='btn btn-primary' href="?choix=ajouter">Ajouter un produit</a>
        <a class='btn btn-primary' href="?choix=afficher">Afficher un produit</a>
    </div>
</div>
<?php

// echo '<pre>';
// print_r($_POST);
// echo '<pre>';

}else{
if(!empty($_POST)){

    foreach($_POST as $cle => $valeur){
        $_POST[$cle]=addSlashes($valeur);
    }

    if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
        // echo '<pre>';
        // print_r($_POST);
        // echo '<pre>';
            $pdo->exec("UPDATE produit SET date_arrivee='$_POST[date_arrivee]', heure_arrivee='$_POST[heure_arrivee]', date_depart='$_POST[date_depart]', heure_depart='$_POST[heure_depart]',id_salle='$_POST[id_salle]',prix='$_POST[prix]', etat='$_POST[etat]' WHERE id_produit='$_GET[id]'");
            header('Location:'.RACINE_SITE.'admin/gestion_produit.php?choix=afficher');
    }else{
        $pdo->exec("INSERT INTO produit(date_arrivee, heure_arrivee, date_depart, heure_depart, id_salle, prix, etat) VALUES ('$_POST[date_arrivee]', '$_POST[heure_arrivee]', '$_POST[date_depart]', '$_POST[heure_depart]', '$_POST[id_salle]', '$_POST[prix]', '$_POST[etat]')");
        header('Location:'.RACINE_SITE.'admin/gestion_produit.php?choix=afficher');
    }
}

if(isset($_GET['choix']) AND $_GET['choix']=='ajouter'){

?>
<div class='h-100 text-center p-4'>
 <p class="fs-3"> Formulaire Produits </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_produit" name="id_produit" />

        <div class="form-group">
        <label for="date_arrivee">Date d'arrivée</label><br>
        <input class="form-control" type="date" id="date_arrivee" name="date_arrivee" placeholder="Date d'arrivée" style="color:grey"/> <br><br>
        </div>

        <div class="form-group">
        <label for="heure_arrivee">Heure d'arrivée</label><br>
        <input class="form-control" type="time" id="heure_arrivee" name="heure_arrivee" placeholder="Heure d'arrivée" style="color:grey"/> <br><br>
        </div>

        <div class="form-group">
        <label for="date_depart">Date de depart</label><br>
        <input class="form-control" type="date" name="date_depart" id="date_depart" placeholder="Date de depart" style="color:grey"/><br><br>
        </div>

        <div class="form-group">
        <label for="heure_depart">Heure de depart</label><br>
        <input class="form-control" type="time" name="heure_depart" id="heure_depart" placeholder="Heure de depart" style="color:grey"/><br><br>
        </div>

        <div class="form-group">
        <label for="id_salle">Salle</label><br>
        <select class="form-control" name="id_salle" style="color:grey">
            <?php
            $res=$pdo->query("SELECT * FROM salle");
            
            while($salle=$res->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='$salle[id_salle]'>$salle[id_salle] - $salle[titre] - $salle[cp] - $salle[ville] - $salle[adresse]</option>";
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="prix">Tarif</label><br>
        <input class="form-control" type="integer" id="prix" name="prix" placeholder="le prix du produit" style="color:grey"><br><br>
        </div>

        <div class="form-group">
        <label for="etat">État</label><br>
        <select class="form-control" name="etat" style="color:grey">
            <option value="Libre">Libre</option>
            <option value="Réservée">Réservée</option>
        </select><br><br>
        </div>

        <input class="form-control btn btn-primary" type="submit" value="Ajouter un produit"/>
    </form>
</div>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='afficher'){
    $resultat = $pdo->query("SELECT * FROM produit");
?>
    <div class='h-100 text-center p-5'>
        <table class="table table-striped">
            <tr class="align-middle">
                <th>ID du produit</th>
                <th>Date d'arrivée</th>
                <th>Heure d'arrivée</th>
                <th>Date de départ</th>
                <th>Heure de départ</th>
                <th>Salle</th>
                <th>Tarif</th>
                <th>État</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
<?php
    while($produits = $resultat->fetch(PDO::FETCH_ASSOC)){
        echo "<tr class='align-middle'>
            <td>$produits[id_produit]</td>
            <td>$produits[date_arrivee]</td>
            <td>$produits[heure_arrivee]</td>
            <td>$produits[date_depart]</td>
            <td>$produits[heure_depart]</td>";
            $res=$pdo->query("SELECT * FROM salle");
            while($salle=$res->fetch(PDO::FETCH_ASSOC)){
                if($salle['id_salle'] == $produits['id_salle'])
                echo "<td>$salle[id_salle] - $salle[titre]<br><img src='$salle[photo]' height=70></td>";
        }
            echo "<td>$produits[prix]</td>
            <td>$produits[etat]</td>
            <td><a href='?choix=modifier&id=$produits[id_produit]'><img src='../inc/img/edit-button.png' height=25></td>
            <td><a href='?choix=supprimer&id=$produits[id_produit]'><img src='../inc/img/trash.png' height=25></a></td>
        </tr>";
        // echo "<pre>";
        // print_r($salle);
        // echo "<pre>";
    }
    echo "</table>";
?>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='supprimer'){
    $pdo->query("DELETE FROM produit WHERE id_produit='$_GET[id]'");
    header('Location:'.RACINE_SITE.'admin/gestion_produit.php?choix=afficher');
}
?>
<?php
if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    $resultat=$pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id]'");
    $produit_actuel=$resultat->fetch(PDO::FETCH_ASSOC);

?>
<div class='h-100 text-center'>
    <p class="fs-3 pt-3"> Formulaire Produits </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_produit" name="id_produit" />

        <div class="form-group">
        <label for="date_arrivee">Date d'arrivée</label><br>
        <input class="form-control" type="date" id="date_arrivee" name="date_arrivee" placeholder="Date d'arrivée" value="<?php if(isset($produit_actuel['date_arrivee'])) echo $produit_actuel['date_arrivee']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="heure_arrivee">Heure d'arrivée</label><br>
        <input class="form-control" type="time" id="heure_arrivee" name="heure_arrivee" placeholder="Heure d'arrivée" value="<?php if(isset($produit_actuel['heure_arrivee'])) echo $produit_actuel['heure_arrivee']; ?>"/> <br><br>
        </div>

        <div class="form-group">
        <label for="date_depart">Date de depart</label><br>
        <input class="form-control" type="date" name="date_depart" id="date_depart" placeholder="Date de depart" value="<?php if(isset($produit_actuel['date_depart'])) echo $produit_actuel['date_depart']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="heure_depart">Heure de depart</label><br>
        <input class="form-control" type="time" name="heure_depart" id="heure_depart" placeholder="Heure de depart" value="<?php if(isset($produit_actuel['heure_depart'])) echo $produit_actuel['heure_depart']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="id_salle">Salle</label><br>
        <select class="form-control" name="id_salle">
            <?php
            $res=$pdo->query("SELECT * FROM salle");
            
            while($salles=$res->fetch(PDO::FETCH_ASSOC))
            {
            ?>
                <option value="<?php echo $salles['id_salle'];?>" <?php if(isset($produit_actuel['id_salle']) AND $produit_actuel['id_salle']==$salles['id_salle']) echo 'selected';?>><?php echo ($salles['id_salle'].' - '.$salles['titre'].' - '.$salles['cp'].' - '.$salles['ville'].' - '.$salles['adresse']);?></option>
           <?php
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="prix">Tarif</label><br>
        <input class="form-control" type="integer" id="prix" name="prix" placeholder="le prix du produit" value="<?php if(isset($produit_actuel['prix'])) echo $produit_actuel['prix']; ?>"/><br><br>
        </div>

        <div class="form-group">
        <label for="etat">État</label><br>
        <select class="form-control" name="etat">
            <option <?php if(isset($produit_actuel['etat']) AND  $produit_actuel['etat']=='Libre') echo 'selected'; ?>>Libre</option>
            <option <?php if(isset( $produit_actuel['etat']) AND  $produit_actuel['etat']=='Réservée') echo 'selected'; ?>>Réservée</option>
        </select><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="Modifier un produit"/>
    </form>
</div>
<?php
}
}
?>

<?php include("../inc/bas.inc.php"); ?>