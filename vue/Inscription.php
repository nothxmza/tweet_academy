<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vue/css/inscription.css?v=1">
    <script src="vue/Js/inscription.js?v=1" defer></script>
    <title>Inscription</title>
</head>
<body>
    <header>

    </header>
    <main>
        <div class="basic-info">
            <img src="vue/img/twilogo.png?v=1" alt="logo"><br>
            <h1>Créer votre compte</h1>
        </div>
        <form action="#" method="post">
            <div class="input-box">
                <input type="text" name="name" id="name" placeholder="Nom et prénom" required>
            </div>
			<div class="input-box">
                <input type="text" name="username" id="username" placeholder="username" required>
                <?php 
                    if($errorMail == 2 || $errorMail == 3)
                    {
                        ?> <p style="color:red">username deja utilise</p><?php
                    } 
                ?>
            </div>
            <div class="input-box">
                <input type="email" name="mail" id="email" placeholder="Adresse Email" required>
                <?php 
                    if($errorMail == 1 || $errorMail == 3)
                    {
                        ?> <p style="color:red">email deja utilise</p><?php
                    }
                ?>
                
            </div>
            <section>
                <p class="title">Date de naissance</p>
                <p class="resume">Cette information ne sera pas affichée publiquement. Confirmez votre âge, même si ce compte est pour une entreprise, un animal de compagnie ou autre chose.</p>
                <div class="date-select">
                    <div class="month-select select-container">
                        <p>Mois</p>
                        <select name="month" id="month-select" required>
                            <option value="none" disabled selected></option>
                            <option value="01">Janvier</option>
                            <option value="02">Février</option>
                            <option value="03">Mars</option>
                            <option value="04">Avril</option>
                            <option value="05">Mai</option>
                            <option value="06">Juin</option>
                            <option value="07">Juillet</option>
                            <option value="08">Août</option>
                            <option value="09">Septembre</option>
                            <option value="10">Octobre</option>
                            <option value="11">Novembre</option>
                            <option value="12">Décembre</option>
                        </select>
                    </div>
                    <div class="day-select select-container">
                        <p>Jour</p>
                        <select name="day" id="day-select" required>
                            <option value="none" disabled selected></option>
                            <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    if ($i < 10) {
                                        $i = "0" . $i;
                                    }
                                    echo "<option value='$i'>$i</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="year-select select-container">
                        <p>Année</p>
                        <select name="year" id="year-select" required>
                            <option value="none" disabled selected></option>
                            <?php
                                for ($i = 2023; $i >= 1905; $i--) {
                                    echo "<option value='$i'>$i</option>";
                                }
                            ?>
                        </div>
                    </div>
                </select>
                </section>
                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                </div>
                <?php if ($errorMail == 4) {
                        ?> <p style="color:red">Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial</p><?php
                    }?>
                <div class="btn-submit">
                    <input type="submit" name="submit" value="S'inscrire" disabled>
                </div>
        </form>
        <a  href="index.php">Connection</a>
    </main>

    <footer>

    </footer>
</body>
</html>