<script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		
		$('.submit').click(function() {
            let valueBio = $('#bio').val();
            let valueBanner = $('#banner').val()
            let valueAvatar = $('#avatar').val()
			let id_user = $('.profil-card').data('user-id');
			
			let defaultBanner = $('.profil-card').data('banner-id');
			let defaultAvatar = $('.profil-card').data('avatar-id');
			let defaultBio = $('.profil-card').data('bio-id');
			if(valueBanner.length != 0){
				valueBanner = valueBanner.split("\\")
				valueBanner = valueBanner[2];
			}
			else
				valueBanner = defaultBanner;
			if(valueAvatar.length != 0){
				valueAvatar = valueAvatar.split("\\")
				valueAvatar = valueAvatar[2];
			}
			else
				valueAvatar = defaultAvatar;
			if(valueBio.length == 0)
				valueBio = defaultBio
			console.log(defaultBanner)
			$.ajax({
                method: "POST",
                url: "vue/requetAjax/insertEdit.php",
                data: {"bio": valueBio, "banner": valueBanner, "avatar": valueAvatar,"id":id_user},
                succes:function(){
                    document.location.href="index.php?action=accueil";
                },
                complete:function(){
                    document.location.href="index.php?action=profile&id=" + id_user;
                },
                error:function(){
                    console.log("twieet profil error")
                }
            })
		});
	})
</script>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier le profil</title>
</head>
<style>
	body{
		background-color: #2b4365;
	}
</style>
<body>
	<div class="profil-card" data-user-id="<?php echo $_SESSION['idUser']; ?>" data-banner-id="<?php echo $info[0]['banner']; ?>" data-avatar-id="<?php echo $info[0]['avatar']; ?>" data-bio-id="<?php echo $info[0]['bio']; ?>">
		<label for="bio">Bio:</label>
        <input type="text" name="bio" id="bio">
        <label for="banner">Banner:</label>
        <input type="file" name="banner" id="banner">
        <label for="avatar">Avatar:</label>
        <input type="file" name="avatar" id="avatar">
        <button type="submit" class="submit" name="submit">Mettre à jour le profil</button>
	</div>
        
</body>
</html>