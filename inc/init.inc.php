<?php 
// connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=eval_php", 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

//Session
session_start();

//Chemin
define("RACINE_SITE", "/ifocop/php/eval_php/");

include('fonction.inc.php');
?>