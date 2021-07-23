<?php include("inc/init.inc.php"); ?>
<?php include("inc/haut.inc.php"); ?>
<?php

if(isset($_GET['categorie'])){

    $resultat = $pdo->query("SELECT * FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle WHERE categorie='$_GET[categorie]'");
    echo "<div class='fs-2 text-center py-5'>Nos produits de la catégorie $_GET[categorie]</div>";
    while( $produit = $resultat->fetch(PDO::FETCH_ASSOC)){
        echo "<div class='text-center position-relative pb-5'>";
        echo "<div class='fs-1 position-absolute' style='z-index:2; left: 30%; top: 5%; color: #fff'>$produit[titre]</div>";
        echo "<a href='fiche_produit.php?id_produit=$produit[id_produit]'><img class='width50' src ='$produit[photo]' /></a>";
        echo "</div>";
     }

}else{

$resultat = $pdo->query("SELECT DISTINCT categorie FROM salle");
?>
<h1 class="p-5 text-center">Lokisalle : Le site idéal pour tous vos événements professionnels!</h1>
<p class="px-5">Le monde du travail est en profonde mutation. Fini les salles de réunions et les postes de travail classiques, dématérialisé, il évolue vers davantage de flexibilité, de nomadisme, et adopte un style libéré. De ce constat, Lokisalle a créé la première marketplace collaborative permettant d’héberger les activités professionnelles chez l’habitant.</p>

<p class="px-5">Location de salle de réunion, de formation et de bureaux : la révolution des espaces de travail partagés Dans les grandes villes, c’est une révolution : à l’aide des nouvelles technologies, Lokisalle réinvente des espaces uniques et atypiques sous-utilisés, à l’intention des professionnels.</p>

<p class="px-5">Avec Lokisalle, vivez l’expérience du travail de demain grâce à cette solution profitant à tous et offrant une diversité d’espace sans pareille : des ateliers d’artistes, des lofts industriels, des boutiques-hôtels, des concepts stores…</p>

<div class="d-flex justify-content-around py-5">
<img class="width25" src="<?php echo RACINE_SITE; ?>inc/img/Blanche.jpeg" alt="">
<img class="width25" src="<?php echo RACINE_SITE; ?>inc/img/Noir.jpeg" alt="">
<img class="width25" src="<?php echo RACINE_SITE; ?>inc/img/Cosy.jpeg" alt="">
</div>
<?php
echo '<div><ul class="list-group list-group-flush list-group-horizontal justify-content-around">';
    while($categorie=$resultat->fetch(PDO::FETCH_ASSOC)){
        echo "<li class='list-group-item text-center border-0'><a class='btn btn-primary mb-5' href='?categorie=$categorie[categorie]'>$categorie[categorie]</a></li>";
    }
echo "</ul></div>";
?>

<p class="fs-2 px-5">Qui sommes nous?</p>
<p class="px-5 pb-5">Depuis 2020, Lokisalle s’est spécialisée dans la location de salles de réunion à Paris et Asnières-sur-Seine. Salles de formation, de réunion, de séminaire, de formation, ou encore de conférence, nous vous proposons une large palette de salles à disposition de tous les professionnels. L’objectif est de permettre à chacun de créer un événement sur-mesure qui lui convient, pour célébrer un lancement de produit, un team building, pour mener à bien une formation ou encore pour organiser un cocktail dinatoire en petit ou en grand comité. Avec notre partenaire culinaire, spécialisé dans la gastronomie française, nous avons à cœur de veiller à votre satisfaction.</p>
<?php
}



?>
<?php include("inc/bas.inc.php"); ?>
