<script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
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
			});
		});
		$("input").on("keyup",function() {
			const inputValue = document.getElementById('result');
			let searchValue = $('#result').val()
			$.ajax({
				type: 'POST',
				url: 'vue/requetAjax/renderSearch.php',
				data:{"searchResult" : searchValue},
				success: function(){
				}//href="index.php?action=profile&username=' + val['username']+
			}).done(function( data ){
                let json = $.parseJSON(data);
				let resultsList = $('#search-results');
				resultsList.empty();
				$.each(json, function(key, val){
					const list = document.createElement('a')
					list.setAttribute("href","index.php?action=profile&username="+ val['username'])
					list.textContent = val["username"]
					const listItem = document.createElement('li')
					listItem.append(list)
					resultsList.append(listItem);
					console.log(json.length)
					if (searchValue.length > 0) {
						resultsList.show();
					}
					else{
						resultsList.hide()
					}
					console.log(searchValue)
				})
			})
		});
	});
</script>
<html>
<head>
    <title>Accueil</title>
	<link rel="stylesheet" href="vue/css/bootstrap/css/bootstrap.min.css">
    <script src="vue/Js/Connection.js"></script>
</head>
<body class="dark-mode">
   
<div class="row">
	<div class="row">
		<div class="col-6">
			<h1>tweet</h1>
			<a href="vue/a.php">repondre</a>

		</div>
		<div class="col-6">
				<input id="result" type="text"  placeholder="Search">
				<ul id="search-results"></ul>
				<button class="search" >Search</button>
		</div>
	</div>
	<?php if(isset($info))
	{?>
	<div class="row">
		<?php 
		$count = count($info);
		$i = 0;
		while($i < $count)
		{
		?>
		<div class="card tweet-card" style="width: 18rem;" data-tweet-id="<?php echo $info[$i]['id_tweet']; ?>">
		<?php if($info[$i]['url'] != ''){
			?>
			<img src="vue/img/<?php echo  $info[$i]['url']?>" class="card-img-top" alt="..." whidth="100px" height="100px">
			<?php } ?>
			<div class="card-body">
				<p class="card-text"><?php echo  $info[$i]['message']?></p>
				<p class="card-text"><?php echo  $info[$i]['date']?></p>
				<a href="index.php?action=reponse&id_tweet= <?php echo $info[$i]['id_tweet'] ?>&name_page=accueil"  class="btn btn-primary">repondre</a>
				<?php if($info[$i]['id_user'] == $_SESSION['idUser'])
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
	<div class="row">
	<form action="#" method="POST">
		<input type="text" name="text" placeholder="text">
		<input type="file" id="imgTweet" name="imgTweet"
       accept="image/png, image/jpeg">
		<button name="submit">entree</button>
	</form>
	</div>
    <a  href="logout.php">Deconnection</a>
</body>
</html>