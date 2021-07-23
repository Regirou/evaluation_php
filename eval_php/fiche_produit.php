<?php include("inc/init.inc.php"); ?>
<?php include("inc/haut.inc.php"); ?>
<?php

if(isset($_GET['id_produit'])){
    $resultat = $pdo->query("SELECT * FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle WHERE id_produit = '$_GET[id_produit]'");
    if($resultat->rowCount()<=0){
        header("Location:reservation.php");
    }else{
       $produit = $resultat->fetch(PDO::FETCH_ASSOC);
       echo "<div class='text-center position-relative py-5'>";
       echo "<div class='fs-1 position-absolute' style='z-index:2; left: 30%; top: 8%; color: #fff'>$produit[titre]</div>";
       echo "<img src='$produit[photo]' class='width50 pb-5'>";
       echo "<p>Déscription: $produit[description]</p>";
       echo "<p>Arrivée: $produit[date_arrivee] $produit[heure_arrivee]</p>";
       echo "<p>Départ: $produit[date_depart] $produit[heure_depart]</p>";
       echo "<p>Catégorie: $produit[categorie]</p>";
       echo "<p>Capacité: $produit[capacite]</p>";
       echo "<p>Adresse: $produit[adresse] $produit[cp] $produit[ville]</p>";
       echo "<p>Prix: $produit[prix] €</p>";
       echo "<form action='panier.php' method='POST' >";
       echo "<input type='hidden' name='id_produit' value='$produit[id_produit]'/>";
       echo "<input class='btn btn-primary' type='submit' name='ajout_panier' value='Ajouter au panier' />";
       echo "</form>";
       echo "</div>";
}
}

?>
<?php include("inc/bas.inc.php"); ?>