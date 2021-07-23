<?php include("inc/init.inc.php"); ?>
<?php include("inc/haut.inc.php"); ?>

<?php
if(isset($_GET['state']) AND $_GET['state']=='reload'){
    $pseudo = $_SESSION['membre']['pseudo'];
    $resultat=$pdo->query("SELECT * FROM membre WHERE pseudo = '$pseudo'");
    $membre_actuel=$resultat->fetch(PDO::FETCH_ASSOC);

    $_SESSION['membre']['prenom']= $membre_actuel['prenom'];
    $_SESSION['membre']['nom']= $membre_actuel['nom'];

        Header('Location:'.RACINE_SITE.'profil.php');   
?>

<?php
}else{
    if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    echo '<div style="height: 850px" class="text-center">
    <p class="fs-3 pt-5">Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'].'</p>';
?>
    <p class="text-center pt-4" style="visibility:hidden"><a class='btn btn-primary' href="?choix=modifier">Modifier mon profil</a></p>
<?php
    }else{
        echo '<div style="height:800px" class="text-center">
        <p class="fs-3 pt-5">Bonjour '.$_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'].'</p>';
    ?>
        <p class="text-center pt-4"><a class='btn btn-primary' href="?choix=modifier">Modifier mon profil</a></p>
    <?php
    }
}


if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
    // echo '<pre>';
    // print_r($_SESSION['membre']['pseudo']);
    // echo '<pre>';
    $pseudo = $_SESSION['membre']['pseudo'];
    // echo '<pre>';
    // print_r($pseudo);
    // echo '<pre>';
    $resultat=$pdo->query("SELECT * FROM membre WHERE pseudo = '$pseudo'");
    $membre_actuel=$resultat->fetch(PDO::FETCH_ASSOC);
?>
<div class='text-center'>
    <form class="w-50 p-3 m-auto" method="post" enctype="multipart/form-data" action=""> 

        <input type="hidden" id="id_membre" name="id_membre" />

        <div class="form-group">
            <label for="nom">Nom</label><br>
            <input class="form-control" type="text" id="nom" name="nom" placeholder="le nom du membre" value="<?php if(isset($membre_actuel['nom'])) echo $membre_actuel['nom']; ?>" required/> <br><br>
        </div>
        <div class="form-group">
            <label for="prenom">Prenom</label><br>
            <input class="form-control" type="text" id="prenom" name="prenom" placeholder="le prenom du membre" value="<?php if(isset($membre_actuel['prenom'])) echo $membre_actuel['prenom']; ?>" required/> <br><br>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label><br>
            <input class="form-control" type="email" id="email" name="email" placeholder="l'e-mail du membre" value="<?php if(isset($membre_actuel['email'])) echo $membre_actuel['email']; ?>" required/> <br><br>
        </div>
        <div class="form-group">
            <label for="civilite">Civilité</label><br>
            <select class="form-control" name="civilite" required>
                <option <?php if(isset($membre_actuel['civilite']) AND $membre_actuel['civilite']=='mme') echo 'selected'; ?>>Mme</option>
                <option <?php if(isset($membre_actuel['civilite']) AND $membre_actuel['civilite']=='mlle') echo 'selected'; ?>>Mlle</option>
                <option <?php if(isset($membre_actuel['civilite']) AND $membre_actuel['civilite']=='mr') echo 'selected'; ?>>Mr</option>
            </select><br><br>
        </div>
        <input class="form-control btn btn-primary mb-5" type="submit" value="Modifier"/>
    </form>
</div>
    <?php
}

if(!empty($_POST)){
    if(isset($_GET['choix']) AND $_GET['choix']=='modifier'){
        $pdo->exec("UPDATE membre SET pseudo='$_POST[pseudo]', nom='$_POST[nom]',prenom='$_POST[prenom]',email='$_POST[email]',civilite='$_POST[civilite]' WHERE pseudo='$pseudo'");
    }
    Header('Location:'.RACINE_SITE.'profil.php?state=reload');
}
?>

<?php include("inc/bas.inc.php"); ?>