<?php

class Edit {
    public EditM $db;

    public function __construct(){
        $this->db = new EditM();
    }

    public function render() {
		if(isset($_SESSION['idUser']))
		{
			$info = $this->db->user($_SESSION['idUser']);

			if(isset($_POST['submit'])){
                $this->db->updateUserProfile($_SESSION['idUser'], $_POST['bio'], $_FILES['banner']['name'], $_FILES['avatar']['name']);
            }
            require('vue/Edit.php');
		}
        else{
			header("location:index.php");
		}
    }
}

?>