<script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		/*let id_user = $('.profil-card').data('user-id');
		console.log(id_user)
		$.ajax({
			type: 'POST',
			url: 'vue/requetAjax/renderTweet.php',
			data:{"id_user": id_user},
		}).done(function(data){
			let json = $.parseJSON(data);
			$.each(json, function(key, val){
                $("#result").append("<div class=\"card delta\" data-reponse-id=" + val['id'] + ">\n" +
                "        <div class=\"card-body\">\n" +
				"    <h6 class=\card-subtitle mb-2 text-muted\">"+ val['message']+"</h6>\n"+
                " <button class=\"delete\" id=" + val['id'] + ">delete</button>\n" +
                "        </div>\n" +
                "</div>");
				if(id_user != val['id_user'])
                {
                      $(".delete").hide()
                }
				$(".delete").click(function() {
                    let reponseCard = $(this).closest('.delta');
			        console.log(reponseCard.data('reponse-id'))
                    $.ajax({
                        type: 'POST',
                        url: 'vue/requetAjax/deleteTweet.php',
                        data: { "tweet_id": reponseCard.data('reponse-id') }, 
                        success: function() {
                            reponseCard.remove();
                        }
			        });
                })
			})
		})*/
		
		$('.delete-tweet').click(function() {
			let tweetCard = $(this).closest('.tweet-card');
			console.log(tweetCard.data('tweet-id'))
			$.ajax({
				type: 'POST',
				url: 'vue/requetAjax/deleteTweet.php',
				data: { tweet_id: tweetCard.data('tweet-id') }, 
				success: function() {
					tweetCard.remove();
				}
			})
        });
        $('.submit').click(function() {
            let valueText = $('#textTweet').val();
            let valueUrl = $('#imgTweet').val()
            let id_user = $('.profil-card').data('user-id');
            valueUrl = valueUrl.split("\\")
			if(valueUrl.length < 1)
				valueUrl = 0
			console.log(valueUrl[2])
            $.ajax({
                method: "POST",
                url: "vue/requetAjax/insertTweetProfile.php",
                data: {"id_user": id_user, "message": valueText, "url": valueUrl[2]},
            })
        });
	});
</script>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vue/css/bootstrap/css/bootstrap.min.css">
    <title>Profil</title>
</head>
<body <?php if (isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] == "dark") { echo "style='background-color: black !important; color: white !important;'"; } ?>>
    <header>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-4">
				<p><a href="index.php?action=accueil">retour</a></p>
                    <?php echo $id_user ?>
					<?php echo $_SESSION['idUser'] ?>
                </div>
                <div class="col-4">
                    <div class="card profil-card" data-user-id="<?php echo $id_user; ?>">  
                        <img src="vue/img/elephant.jpg" class="card-img-top" alt="..." whidth="100px" height="100px">
                        <div class="card-body">
                            <h5 class="card-title">@<?php echo $infoUser["username"] ?></h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted"><?php echo $infoUser["created_at"] ?></small></p>
                        </div>
                    </div>
					<?php if( $id_user == $_SESSION['idUser']){
						?> 
						<form action="#" method="POST">
							<input type="text" name="text" id="textTweet" placeholder="text">
                        <input type="file" id="imgTweet" name="imgTweet"
                                    accept="image/png, image/jpeg">
                        <button class="submit" name="submit">entree</button>
						</form>
						<?php
						}
                        if(isset($infoTweet))
                        {?>
							<div class="row">
								<?php 
								$count = count($infoTweet);
								$i = 0;
								while($i < $count)
								{
								?>
								<div class="card tweet-card" style="width: 18rem;" data-tweet-id="<?php echo $infoTweet[$i][0]; ?>">
								<?php if(isset($infoTweet[$i]['url'])){
										if($infoTweet[$i]['url'] != ''){

									?>
									<img src="vue/img/<?php echo  $infoTweet[$i]['url']?>" class="card-img-top" alt="..." whidth="100px" height="100px">
									<?php } }?>
									<div class="card-body">
										<p class="card-text"><?php echo  $infoTweet[$i]['message']?></p>
										<p class="card-text"><?php echo  $infoTweet[$i]['date']?></p>
										<a href="index.php?action=reponse&id_tweet=<?php echo $infoTweet[$i][0]?>&name_page=profile&username=<?php echo $_GET['username']?>"  class="btn btn-primary">repondre</a>
										<?php if($infoTweet[$i]['id_user'] == $_SESSION['idUser'])
										{
											?> <button name="delete" class="btn btn-danger delete-tweet">supprimer</button><?php
											
										}  ?>
									</div>
								</div><?php
								$i++;
								}
								?>
                        	</div><?php
                        }?>
                </div>
				<div id="result">
            
				</div>
                <div class="col-4">
                	<a  href="logout.php">Deconnection</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
    </footer>
</body>
</html>

<html>
<head>
    <title>Connexion</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous"></script>
    <link rel="stylesheet" href="vue/css/bootstrap/css/bootstrap.min.css">
</head>
<body class="dark-mode">
    <?php if($_GET['name_page'] == 'profile')
    {
        ?>
        <p><a href="index.php?action=<?php echo $_GET['name_page']; ?>&username=<?php echo $_GET['username']?>">retour</a></p>
        <?php
    }else{
        ?>
        <p><a href="index.php?action=<?php echo $_GET['name_page']; ?>">retour</a></p>
        <?php
    }
    ?>
        <div class="card tweet-card" style="width: 18rem;" data-tweet-id="<?php echo $info[0]['id_tweet']; ?>" data-id-user="<?php echo $_SESSION['idUser']; ?>">
			<img src="vue/img/<?php echo  $info[0]['url']?>" class="card-img-top" alt="..." whidth="100px" height="100px">
			<div class="card-body">
				<p class="card-text"><?php echo  $info[0]['message']?></p>
				<p class="card-text"><?php echo  $info[0]['date']?></p>
			</div>
            <div class="row">
                <div class="col-6">
                     <input type="text" name="reponse" class="reponse" id="input" placeholder="reponse">
                </div>
               <div class="col-6">
               <button class="submit" name="submit">entree</button>
               </div>
            </div>
		</div>
        <div id="result">
            
        </div>
    <a  href="logout.php">Deconnection</a>
</body>
</html>