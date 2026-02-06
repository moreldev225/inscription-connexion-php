<?php
    /*$serveur ="localhost";
$login= "root";
$pass = "root";

$error_msg = "";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=projet;charset=utf8", $login, $pass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = trim($_POST["email"]);
    $mdp = trim($_POST["mdp"]);

    if ($email != "" && $mdp != "") {

      $token = bin2hex(random_bytes(32));
        // Sécuriser la requête
        $requete = $connexion->prepare(
            "SELECT * FROM inscrit WHERE email = :email AND mdp = :mdp"
        );

        $requete->execute( 
            array(
                ':email' => $email,
                ':mdp' => $mdp

            )
        );
        $connexion->exec("UPDATE inscrit SET token ='$token' WHERE email ='$email' AND mdp = '$mdp'  ");
        setcookie("token", $token, time() +3600);
        
        $reponse = $requete->fetch(PDO::FETCH_ASSOC);

        if ($reponse) {
          header("location: connect.php");
        } else { 
            $error_msg = "Email ou mot de passe incorrect.";
        }
    }
   
}*/   # ENCIENNE VERSION DU CODE DE CONNEXION A MODIFIER PLUS TARD




session_start();
require_once('dbname.php');


$error_msg = "";


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $email = trim($_POST["email"]);
    $mdp = trim($_POST["mdp"]);

    if (!empty($email) && !empty($mdp)) {

        // Récupérer l'utilisateur par email
        $requete = $connexion->prepare(
            "SELECT * FROM users WHERE email = :email"
        );
        $requete->execute(['email' => $email]);
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        


        // Vérification du mot de passe
        if ($user && password_verify($mdp, $user['mdp'])) {

            // Sécurisation de la session
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['last_activity'] = time();
           

            // Option "se souvenir de moi"
            if (!empty($_POST['remember'])) {
                $token = bin2hex(random_bytes(32));

                $update = $connexion->prepare(
                    "UPDATE users SET token = :token WHERE id = :id"  );
                $update->execute([ 'token' => $token, 'id' => $user['id'] ]);

                setcookie(  "token", $token, time() + 3600, "/",  "",   false,   true );
            }
                  
           

        } else {
            $error_msg = "Email ou mot de passe incorrect.";
        }
    }

    header("Location: template.php");
            exit();

}
?>


 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page de connexion</title>
    <link rel="stylesheet" href="syle/style.css">
</head>
<body>

<form action="" method="POST">

<div class="nav" >

<h1 class="haut"> connexion</h1>
<div class="box" >
    <label for="email">entrez votre email</label>
    <input type="email" name="email" id="email" placeholder="votre email" required><br>
    
    <label for="mdp">entrez votre mot de passe</label>
    <input type="password" name="mdp" id="mdp" placeholder="votre mot de passe" required>

     <input type="checkbox" name="remember" id="remember"> Se souvenir de moi  

     <a href="#">Mot de passe oublié ?</a>
     </div>

    <div class="btn">
    <input type="submit" value="Se connecter" name="Se connecter"> </div>

    <div class="compte"><p>Pas de compte  <a href="inscription.php">s'inscrire</a></p></div>
</div>
    
</div>
</form>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>
