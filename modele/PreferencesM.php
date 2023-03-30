<?php 

require_once('DataBase.php');

class PreferencesM 
{
    public DataBase $base;
    public ?\PDO $db;
    public $id = 0;

    public function __construct() {
        $this->base = new DataBase();
        $this->db = $this->base->CoDb();
    }

    public function getPreferences() {
        $requete = "SELECT * from preferences where id_user = :id_user";
        $user = $this->db->prepare($requete);
        $user->execute([
            'id_user' => $_SESSION['idUser']
        ]);
        $info = $user->fetch();
        //si la requete ne retourne rien, on insert les preferences par defaut
        if(empty($info)) {
            $this->insertPreferences("white", "fr");
            $info = $this->getPreferences();
        }
        return $info;
    }

    public function insertPreferences($dark_mode, $lang) {
        $requete = "INSERT INTO preferences (id_user, darkmode, lang) VALUES (:id_user, :dark_mode, :lang)";
        $user = $this->db->prepare($requete);
        $user->execute([
            'id_user' => $_SESSION['idUser'],
            'dark_mode' => $dark_mode,
            'lang' => $lang
        ]);
    }

    public function updatePreferences($dark_mode, $lang){
        $darkmode_value = $dark_mode ? "dark" : "white";
        $requete = "UPDATE preferences SET darkmode = :dark_mode, lang = :lang WHERE id_user = :id_user";
        $user = $this->db->prepare($requete);
        $user->execute([
            'dark_mode' => $darkmode_value,
            'lang' => $lang,
            'id_user' => $_SESSION['idUser']
        ]);
    }
}