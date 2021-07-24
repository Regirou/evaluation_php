<?php include("../inc/init.inc.php"); ?>
<?php include("../inc/haut.inc.php"); ?>

<?php
if(empty($_POST) AND !isset($_GET['choix'])){
?>
<div style="height: 800px">
    <p class="text-center pt-5"><img src="<?php echo RACINE_SITE; ?>inc/img/Cosy.jpeg" alt="" class="width25"></p>
    <p class="fs-4 pt-4 text-center">Cliquez sur les boutons pour ajouter une commande ou afficher des commandes</p>
    <div class="d-flex my-5 justify-content-around">
        <a class='btn btn-primary' href="?choix=ajouter">Ajouter une commande</a>
        <a class='btn btn-primary' href="?choix=afficher">Afficher une commande</a>
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
            $pdo->exec("UPDATE commande SET id_membre='$_POST[id_membre]', id_produit='$_POST[id_produit]', date_enregistrement='$_POST[date_enregistrement]' WHERE id_commande='$_GET[id]'");
            header('Location:'.RACINE_SITE.'admin/gestion_commande.php?choix=afficher');
            ob_end_flush();
    }else{
        $pdo->exec("INSERT INTO commande(id_membre, id_produit, date_enregistrement) VALUES ('$_POST[id_membre]', '$_POST[id_produit]', '$_POST[date_enregistrement]')");
        header('Location:'.RACINE_SITE.'admin/gestion_commande.php?choix=afficher');
        ob_end_flush();
    }
}

if(isset($_GET['choix']) AND $_GET['choix']=='ajouter'){

?>
<div style='height:800px' class='text-center p-4'>
 <p class="fs-3"> Formulaire Commandes </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_commande" name="id_commande" />

        <div class="form-group">
        <label for="id_membre">ID du membre</label><br>
        <select style="color:grey" class="form-control" name="id_membre">
            <?php
            $resultat=$pdo->query("SELECT * FROM membre");
            while($membre=$resultat->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='$membre[id_membre]'>$membre[id_membre] - $membre[nom] - $membre[prenom] - $membre[email]</option>";
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="id_produit">ID du produit</label><br>
        <select style="color:grey" class="form-control" name="id_produit">
            <?php
            $resultat2=$pdo->query("SELECT * FROM produit INNER JOIN salle ON salle.id_salle=produit.id_salle ");
            while($produit=$resultat2->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='$produit[id_produit]'>$produit[id_produit] - $produit[titre] - $produit[date_arrivee] - $produit[date_depart] - $produit[prix]</option>";
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="date_enregistrement">Date d'enrégistrement</label><br>
        <input style="color:grey" class="form-control" type="date" name="date_enregistrement" id="date_enregistrement" placeholder="date_enregistrement"/><br><br>
        </div>

        <input class="form-control btn btn-primary" type="submit" value="Ajouter une  commande"/>
    </form>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='afficher'){
    $resultat3 = $pdo->query("SELECT * FROM commande");
    ?>
    <div style='height:800px' class='text-center p-5'>
        <table class="table table-striped table-responsive">
            <tr class="align-middle">
                <th>ID de la commande</th>
                <th>ID du membre</th>
                <th>ID du produit</th>
                <th>Date d'enrégistrement</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
<?php
    while($commandes = $resultat3->fetch(PDO::FETCH_ASSOC)){
        echo "
        <tr>
            <td>$commandes[id_commande]</td>
            <td>$commandes[id_membre]</td>
            <td>$commandes[id_produit]</td>
            <td>$commandes[date_enregistrement]</td>
            <td><a href='?choix=modifier&id=$commandes[id_commande]'><img src='../inc/img/edit-button.png' height=25></td>
            <td><a href='?choix=supprimer&id=$commandes[id_commande]'><img src='../inc/img/trash.png' height=25></a></td>
        </tr>";
    }
    echo "</table>";
?>
<?php 
}

if(isset($_GET['choix']) AND $_GET['choix']=='supprimer'){
    $pdo->query("DELETE FROM commande WHERE id_commande='$_GET[id]'");
    header('Location:'.RACINE_SITE.'admin/gestion_commande.php?choix=afficher');
    ob_end_flush();
}
?>
<?php
if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    $resultat3=$pdo->query("SELECT * FROM commande WHERE id_commande = '$_GET[id]'");
    $commande_actuel=$resultat3->fetch(PDO::FETCH_ASSOC);

?>
<div style='height: 800px' class='text-center'>
    <p class="fs-3 pt-3"> Formulaire Commandes </p>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 
        <input type="hidden" id="id_commande" name="id_commande" />

        <div class="form-group">
        <label for="id_membre">ID du membre</label><br>
        <select class="form-control" name="id_membre">
            <?php
            $resultat=$pdo->query("SELECT * FROM membre");
            while($membre=$resultat->fetch(PDO::FETCH_ASSOC)){
            ?>
                <option value="<?php echo $membre['id_membre']; ?>"<?php if(isset($commande_actuel['id_membre']) AND $commande_actuel['id_membre']==$membre['id_membre']) echo 'selected='.$membre['id_membre'];?>><?php echo $membre['id_membre'].' - '.$membre['nom'].' - '.$membre['prenom'].' - '.$membre['email']?></option>
            <?php
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="id_produit">ID du produit</label><br>
        <select class="form-control" name="id_produit">
            <?php
            $resultat2=$pdo->query("SELECT * FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle ");

            while($produit=$resultat2->fetch(PDO::FETCH_ASSOC)){
            ?>
                <option value="<?php echo $produit['id_produit']; ?>"<?php if(isset($commande_actuel['id_produit']) AND $commande_actuel['id_produit']==$produit['id_produit']) echo 'selected='.$produit['id_produit'];?>><?php echo $produit['id_produit'].' - '.$produit['titre'].' - '.$produit['date_arrivee'].' - '.$produit['date_depart'].' - '.$produit['prix']?></option>
            <?php    
            }
            ?>
        </select><br><br>
        </div>

        <div class="form-group">
        <label for="date_enregistrement">Date d'enrégistrement</label><br>
        <input class="form-control" type="date" name="date_enregistrement" id="date_enregistrement" placeholder="Date d'enregistrement'" value="<?php if(isset($commande_actuel['date_enregistrement'])) echo $commande_actuel['date_enregistrement']; ?>"/><br><br>
        </div>

        <input class="form-control btn btn-primary mb-5" type="submit" value="Modifier une commande"/>
    </form>
<?php
}
}
?>

<?php include("../inc/bas.inc.php"); ?>