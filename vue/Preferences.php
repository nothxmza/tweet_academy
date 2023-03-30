<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vue/css/Preferences.css">
    <script src="vue/js/preferences.js?v=1" defer></script>
    <title>Preferences</title>
</head>
<style>
	body{
		background-color: #2b4365;
	}
</style>
<body <?php if ($dark_mode === 'dark') { echo 'style="background-color: black !important; color: #2b4365 !important;"'; } ?>>
    <input type="button" id="returnBtn" value="<-" onclick="history.go(-1)">
    <section>
        <h1>Preferences</h1>
        <form action="index.php?action=preferences" method="post">
            <label for="dark_mode">Dark mode</label>
            <input type="checkbox" name="dark_mode" id="dark_mode" <?php if ($dark_mode) { echo "checked"; } ?>>
            <div class="spacer">
                <label for="lang">Language</label><br>
                <select name="lang" id="lang">
                    <option value="en" <?php if ($lang === 'en') { echo 'selected'; } ?>>English</option>
                    <option value="fr" <?php if ($lang === 'fr') { echo 'selected'; } ?>>Français</option>
                    <option value="es" <?php if ($lang === 'es') { echo 'selected'; } ?>>Español</option>
                    <option value="de" <?php if ($lang === 'de') { echo 'selected'; } ?>>Deutsch</option>
                    <option value="it" <?php if ($lang === 'it') { echo 'selected'; } ?>>Italiano</option>
                    <option value="pt" <?php if ($lang === 'pt') { echo 'selected'; } ?>>Português</option>
                </select>
            </div>
            <input type="submit" name="submit" value="Save">
        </form>
    </section>
</body>
</html>