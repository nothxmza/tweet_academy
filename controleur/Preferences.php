<?php

class Preferences 
{
    public PreferencesM $userDb;

    public function __construct() {
        $this->userDb = new PreferencesM();
    }

    public function render() {
        if (!isset($_SESSION['idUser'])) {
            header('Location: index.php');
            exit;
        }
        $preferences = $this->userDb->getPreferences();
        $dark_mode = $preferences['darkmode'] ?? null;
        $lang = $preferences['lang'] ?? 'en';

        if (isset($_POST['submit'])) {
            $this->userDb->updatePreferences(isset($_POST['dark_mode']), $_POST['lang'] ?? 'en');
            $_SESSION['dark_mode'] = isset($_POST['dark_mode']);
            $_SESSION['lang'] = $_POST['lang'] ?? 'en';
            header("location:index.php?action=accueil");
        }

        require('vue/preferences.php');
    }

}