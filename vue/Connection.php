<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="vue/css/Connection.css">
    <script src="vue/Js/Connection.js"></script>
</head>
<body class="dark-mode">
    <form action="#" method="POST">
		<img src="vue/img/twilogo.png" class="twilogo">
        <h1>Connectez-vous</h1>
        <label for="mail">
        <input type="text" id="mail" name="mail" placeholder="adresse email ou Nom d'utilisateur" required>

        <label for="password">
        <input type="password" id="password" name="password" placeholder="Mot de passe" required>

        <?php 
            if($errorMailPassword == 1)
            {
                ?> <p style="color:red">error mail or password</p><?php
            }
        ?>
                
    <div class="button-container">
        <input type="submit" name="submit" id="button" disabled value="Connexion">
        <input type="submit" name="forgot" value="Mot de passe oublié ?">
    </div>
        <p>Vous n'avez pas de compte ? </br> <a href="index.php?action=inscription">Inscrivez-vous</a></p>
    </form>
    <a  href="logout.php">Deconnection</a>
</body>
</html>