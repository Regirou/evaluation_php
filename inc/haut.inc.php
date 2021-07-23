<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokkisalle - société proposant la location de salles de réunion à ses clients</title>
    <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/style/style.css">
    <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/bootstrap/bootstrap.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    
    </head>
    <body>    
        <header>
            <div class="container-fluid gx-0">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-md">
                        <?php
                        if(internauteConnecteEstAdmin()){
                        ?>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>admin/gestion_salle.php">Gestion des salles</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>admin/gestion_produit.php">Gestion des produits</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>admin/gestion_membre.php">Gestion des membres</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>admin/gestion_commande.php">Gestion des commandes</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>admin/gestion_avis.php">Gestion des avis</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>connexion.php?action=deconnexion">Se déconnecter</a>
                        <?php
                        }elseif(internauteEstConnecte()){
                        ?>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>reservation.php" title="Lokisalle">Lokisalle.com</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>reservation.php">Réservation</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>panier.php">Panier</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>connexion.php?action=deconnexion">Se déconnecter</a>
                        <?php
                        }else{ 
                        ?>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>reservation.php" title="Lokisalle">Lokisalle.com</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>inscription.php">Inscription</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>connexion.php">Connexion</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>reservation.php">Réservation</a>
                        <a class="navbar-brand mx-auto text-center" href="<?php echo RACINE_SITE; ?>panier.php">Panier</a>
                        <?php
                        }
                        ?>
                    </div>
                </nav>
            </div>
        </header>
        <main>