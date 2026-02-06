<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/syle/inscript.css">
   
</head>
<body>
    <form action="traite.php" method="POST">
        <h1>Formulaire d'Inscription</h1>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="motdepasse">Mot de passe :</label>
        <input type="password" id="motdepasse" name="motdepasse" required>

        <input type="submit" value="S'inscrire" name="S'inscrire">

        <p>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></p>
    </form>
</body>
</html>