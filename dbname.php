<?php

$serveur = "localhost";
$login = "root";
$pass ='root';


try{
      $connexion = new PDO("mysql:host=$serveur;dbname=authentificatio",$login , $pass);
      $connexion->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

}

catch(PDOException $e){

      echo" erreur ". $e->getMessage()  ;
}















?>