<?php
require_once('dbname.php');



if(isset($_POST["S'inscrire"])){


 $nom = trim($_POST['nom']);
 $prenom = trim($_POST['prenom']);
 $pseudo = trim($_POST['pseudo']);
 $email = trim($_POST['email']);
 $mdp = trim($_POST['motdepasse']);


 
//vérification si  le mail exist 
 $verifyMail=$connexion->prepare("SELECT * FROM users WHERE email = :email");
 $verifyMail->execute(['email' => $email]);


if($verifyMail->rowCount()>0){
echo "email exist";
exit;
}



// protection du mot de pass
$mdp_hash = password_hash($mdp , PASSWORD_DEFAULT);


//insersion 
$requete= $connexion->prepare("INSERT INTO users(nom , prenom , pseudo , email , mdp)
VALUES(:nom , :prenom ,:pseudo ,:email ,:mdp)");

$requete->execute([
    'nom'=>$nom,
    'prenom'=>$prenom,
    'pseudo'=>$pseudo,
    'email'=>$email,
    'mdp'=>$mdp_hash


]);

header('Location: login.php');
exit();
}

?>