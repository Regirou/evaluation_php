<?php include("inc/init.inc.php"); ?>
<?php include("inc/haut.inc.php"); ?>


<?php
if(!empty($_POST['ajout_panier'])){
    // echo "<pre>";
    // print_r($_POST);
    // echo "<pre>";
    $resultat=$pdo->query("SELECT * FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle WHERE id_produit='$_POST[id_produit]'");
    $produit=$resultat->fetch(PDO::FETCH_ASSOC);

    ajouterProduitDansPanier($produit['id_produit'],$produit['titre'],$produit['photo'], $produit['categorie'], $produit['capacite'], $produit['adresse'], $produit['cp'],$produit['ville'],$produit['date_arrivee'], $produit['heure_arrivee'], $produit['date_depart'], $produit['heure_depart'], $produit['prix']);
}
?>
<div style='height:850px' class='text-center p-5'>
<table class='table pt-5 table-striped'>
<tr class='align-middle'>
<th>Titre</th>
<th>Photo</th>
<th>Catégorie</th>
<th>Capacité</th>
<th>Adresse</th>
<th>Code postal</th>
<th>Ville</th>
<th>Date d'arrivée</th>
<th>Heure d'arrivée</th>
<th>Date de départ</th>
<th>Heure de départ</th>
<th>Prix</th>
<th>Supprimer</th>
</tr>

<?php
if(empty($_SESSION['panier']['id_produit'])){
    echo "<tr class='align-middle'><td colspan='14'>Votre panier est vide</td></tr>";
}else{
    // echo "<tr><td colspan='12'>Votre panier contient des produits</td></tr>";
    for($i=0; $i<count($_SESSION['panier']['id_produit']); $i++){
        echo "<tr class='align-middle'>";
        echo "<td>".$_SESSION['panier']['titre'][$i]."</td>";
        echo "<td><img src=".$_SESSION['panier']['photo'][$i]." height=70></td>";
        echo "<td>".$_SESSION['panier']['categorie'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['capacite'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['adresse'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['cp'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['ville'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['date_arrivee'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['heure_arrivee'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['date_depart'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['heure_depart'][$i]."</td>";
        echo "<td>".$_SESSION['panier']['prix'][$i]."€</td>";
        $idProduit=$_SESSION['panier']['id_produit'][$i];
        echo "<td><a href='?choix=supprimer&id=$idProduit'><img src='inc/img/trash.png' height=25></a></td>";
        echo "</tr>";
    }
}
echo "<tr my-5><td colspan='14'><a class='btn btn-primary' href='reservation.php'>Réglement par carte</a></td></tr>
</table>
</div>";
// echo "<pre>";
// print_r($_GET);
// echo "<pre>";


if(isset($_GET['choix']) AND $_GET['choix']=='supprimer' ){

    $position_produit = array_search($_GET['id'], $_SESSION['panier']['id_produit']);

    if($position_produit !== false){
        unset($_SESSION['panier']['id_produit'][$position_produit]);
        unset($_SESSION['panier']['titre'][$position_produit]);
        unset($_SESSION['panier']['photo'][$position_produit]);
        unset($_SESSION['panier']['categorie'][$position_produit]);
        unset($_SESSION['panier']['capacite'][$position_produit]);
        unset($_SESSION['panier']['adresse'][$position_produit]);
        unset($_SESSION['panier']['cp'][$position_produit]);
        unset($_SESSION['panier']['ville'][$position_produit]);
        unset($_SESSION['panier']['date_arrivee'][$position_produit]);
        unset($_SESSION['panier']['heure_arrivee'][$position_produit]);
        unset($_SESSION['panier']['date_depart'][$position_produit]);
        unset($_SESSION['panier']['heure_depart'][$position_produit]);
        unset($_SESSION['panier']['prix'][$position_produit]);
      
    }

    header('Location:'.RACINE_SITE.'panier.php');
    ob_end_flush();
}

?>

<?php include("inc/bas.inc.php"); ?>