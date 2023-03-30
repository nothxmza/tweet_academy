<script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous"></script>
<script>///la recherche a faire
	$(document).ready(function() {
		$('.delete-tweet').click(function() {
			let tweetCard = $(this).closest('.tweet-card');
            let tendance_id = $('.tendance').data('tendance-id');
            console.log(tweetCard.data('tweet-id'))
			$.ajax({
				type: 'POST',
				url: 'vue/requetAjax/deleteTweet.php',
				data: { tweet_id: tweetCard.data('tweet-id') }, 
				success: function() {
					tweetCard.remove();
				}
			}).done(function(data){
                let json = $.parseJSON(data);
                console.log(data)
                $.each(json, function(key, val){

                    const test = document.getElementsByClassName("occu")
                    for(i = 0; i < $('.tendance').length;i++)
                    {
                        console.log(test[i].textContent);
                        if($('.tendance').eq(i).data('tendance-id') == val['hashtag'])
                        {
                            let nbr = val["occurences"]  - 1
                            if(nbr > 0)
                            {
                                if(nbr == 1)
                                    test[i].textContent = nbr + " tweet"
                                else
                                    test[i].textContent = nbr + " tweets"
                            }
                            //$('.contentOcc').append("<p class=\"px-4 ml-2 mb-3 w-48 text-xs text-gray-400 occu\" data-occu-id=\"" + nbr + "\">" + nbr + "</p>")
                            else{
                                const tendance = $('.tendance').eq(i)
                                tendance.remove();
                                document.location.href="index.php?action=accueil";
                            }
                        }
                    }
                    if('.tendance' == null)
                        console.log($('.tendance'))
                    else
                        console.log("nn null");
                })
            })
		});
        $('.submit').click(function() {
            let valueText = $('#textTweet').val();
            let valueUrl = $('#imgTweet').val()
            let id_user = $('.profil-card').data('user-id');
            console.log(valueText + " " + valueUrl )
            valueUrl = valueUrl.split("\\")
			if(valueUrl.length < 1)
				valueUrl = 0
			console.log(valueUrl[2])
            $.ajax({
                method: "POST",
                url: "vue/requetAjax/insertTweetProfile.php",
                data: {"id_user": id_user, "message": valueText, "url": valueUrl[2]},
                succes:function(){
                    console.log("twieet profil succes")
                },
                complete:function(){
                    console.log("twieet profil complete")
                },
                error:function(){
                    console.log("twieet profil error")
                }
            })
        });
		$(".resultSearch").on("keyup",function() {
			let searchValue = $('#resultSearch').val()
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
                    console.log(val)
					const list = document.createElement('a')
                    if(val['username'] != null){
                        console.log("ok")
                        list.setAttribute("href","index.php?action=profile&username="+ val['username'])
					    list.textContent = val["username"]
                    }
                    else if(val['hashtag'] != null){
                        console.log("ok2")
                        list.setAttribute("href","index.php?action=hashtag&name="+ val["hashtag"].substr(1))
					    list.textContent = val["hashtag"]
                    }
					const listItem = document.createElement('li')
					listItem.append(list)
					resultsList.append(listItem);
					//console.log(json.length)
					if (searchValue.length > 0) {
						resultsList.show();
					}
					else{
						resultsList.hide()
					}
					//console.log(searchValue)
				})
			})
		});
        $('.follow').click(function(){
            let card = $(".card-User")
            let user = $(this).closest('.card-User')
            let userHome = $(".card-User").data('id-home')
            console.log($(this).closest('.card-User').data('id-follow') )
            const btn = $('.follow').eq(0)
            $.ajax({
                type: 'POST',
                url: 'vue/requetAjax/addFollow.php',
                data:{"id_follow":user.data('id-follow'),"id_user": userHome},
                succes: function(){
                    
                },
                complete:function(){
                },
            }).done(function(data){
                let json = $.parseJSON(data);
                $.each(json, function(key, val){
                    console.log(val);
                    for(i = 0; i < $('.card-User').length;i++){
                        if($('.card-User').eq(i).data('id-follow') == val[3])
                        {
                            $('.card-User').eq(i).remove()
                        }
                    }
                })
            })
        })
	});
</script>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Twitter</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-blue-900 h-screen">
        <div class="flex">

            <div class="w-2/5 text-white h-12 pl-32 py-4 h-auto">
                <!--MENU A GAUCHE-->
              <svg viewBox="0 0 24 24" class="h-12 w-12 text-white" fill="currentColor"><g><path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"></path></g></svg>
              
              <nav class="mt-5 px-2">
                <a href="index.php?action=accueil" class="group flex items-center px-2 py-2 text-base leading-6 font-semibold rounded-full bg-blue-800 text-blue-300">
              <svg class="mr-4 h-6 w-6 " stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"/>
              </svg>
              Accueil
            </a>
            <a href="#" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-semibold rounded-full hover:bg-blue-800 hover:text-blue-300">
              <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
              
              Explorer
            </a>
            <a href="#" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
              <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
             Notifications
            </a>
            
            <a href="#" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
              <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
              Messages
            
            </a>
                <a href="index.php?action=profile&id=<?php echo $_SESSION['idUser']; ?>" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profil
            </a>
                <a  href="logout.php" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
              <svg class="mr-4 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
             Deconnection
            </a>
                <button  data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="bg-blue-400 w-48 mt-5 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full">
                            Tweet
                </button>
            <!-- Main modal -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                <div class="relative w-full h-full max-w-md md:h-auto">
                    <!-- Modal content -->
                    <form action="#" method="POST" class="bg-blue-900 testw profil-card" style="border-radius: 8px" data-user-id="<?php echo $_SESSION['idUser']; ?>">
                    <div class="flex">
                        <div class="m-2 w-10 py-1">
                            <button class="left-form">X</button>
                            <img class="inline-block h-10 w-10 rounded-full" src="vue/img/<?php echo $infoUser['avatar'] ?>" alt="" />
                        </div>
                        <div class="flex-1 px-2 pt-2 mt-2">
                            <textarea class=" bg-transparent text-gray-400 font-medium text-lg w-full" id="textTweet"  name="text" rows="2" cols="50" placeholder="Quoi de neuf ?"></textarea>
                        </div>                    
                    </div>
                <!--ICONS REDACTION TWEET-->
                    <div class="flex">
                        <div class="w-10"></div>
                        <div class="w-64 px-2">
                            <div class="flex items-center">
                                <div class="flex-1 text-center px-1 py-1 m-2">
                                    <label class="t-1 group flex items-center text-blue-400 px-2 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                                            <svg class="text-center h-7 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <input type="file" id="imgTweet" name="imgTweet"
                                            accept="image/png, image/jpeg" style="display:none">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <button class="bg-blue-400 mt-5 hover:bg-blue-600 text-white font-bold py-2 px-8 rounded-full mr-8 float-right submit" name="submit">
                                Tweet
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div> 
          </nav>
            <div class="flex-shrink-0 flex hover:bg-blue-00 rounded-full p-4 mt-12 mr-2">
            <a href="#" class="flex-shrink-0 group block">
                <div class="flex items-center">
                <div>
                    <img class="inline-block h-10 w-10 rounded-full" src="vue/img/<?php echo $infoUser['avatar'] ?>" alt="" />
                </div>
                <div class="ml-3">
                    <p class="text-base leading-6 font-medium text-white">
                    <?php echo $infoUser['name'] ?>
                    </p>
                    <p class="text-sm leading-5 font-medium text-gray-400 group-hover:text-gray-300 transition ease-in-out duration-150">
                    @<?php echo $infoUser['username'] ?>
                    </p>
                </div>
                </div>
            </a>
            </div>
        </div>
            <div class="w-3/5 border border-gray-600 h-auto  border-t-0" style="overflow: scroll">
                <!--FIL D'ACTUALITÉ-->
                <div class="flex">
                    <div class="flex-1 m-2">
                        <h2 class="px-4 py-2 text-xl font-semibold text-white">Hashtag</h2>
                    </div>
                    <div class="flex-1 px-4 py-2 m-2">
                        <a href="" class=" text-2xl font-medium rounded-full text-white hover:bg-blue-800 hover:text-blue-300 float-right">
                            <svg class="m-2 h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><g><path d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path></g>
                            </svg>
                        </a>
                    </div>
                </div>
                   
                <hr class="border-blue-800 border-4">
            <div>
            </div>
                <!--DEUXIEME TWEET-->
			<?php if(isset($hashtagAll))
			{
				$count = count($hashtagAll);
				$i = 0;
				while($i < $count)
				{
			?>
           <?php if($hashtagAll[$i]["parent"] == null)
           {?>

            <div class="tweet-card" data-tweet-id="<?php echo $hashtagAll[$i]["tweet_id"]; ?>">
                <div class="flex flex-shrink-0 p-4 pb-0">
                    <a href="#" class="flex-shrink-0 group block">
                    <div class="flex items-center">
                        <div>
                        <img class="inline-block h-10 w-10 rounded-full" src="vue/img/<?php echo $hashtagAll[$i]['avatar'] ?>" alt="" />
                        </div>
                        <div class="ml-3">
                        <p class="text-base leading-6 font-medium text-white">
                            <a href="index.php?action=profile&username= <?php echo $hashtagAll[$i]['username'] ?>"> <?php echo $hashtagAll[$i]['name'] ?> </a>
                            <span class="text-sm leading-5 font-medium text-gray-400 group-hover:text-gray-300 transition ease-in-out duration-150">
                            @<?php echo $hashtagAll[$i]['username'] ?> 
                            </span>
                            </p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="pl-16">
                    <p class="text-base width-auto font-medium text-white flex-shrink" style="padding: 10px">
                    <?php echo  $hashtagAll[$i]['message']?>
                    </p>
                    <div class="md:flex-shrink pr-6 pt-3">
                    <?php if($hashtagAll[$i]['url'] != ''){
                            ?>
                    <!-- <img class="rounded-lg w-full h-64" src="img/drift.png" alt="driftpic">-->
                <img class="rounded-lg w-full h-64" src="vue/img/<?php echo  $hashtagAll[$i]['url']?>" alt="">
                    <?php } ?>
                    </div>
                    <div class="flex">

                        <div class="w-full">
                            <div class="flex items-center">
                                <div class="flex-1 text-center">
                                    <a href="index.php?action=reponse&id_tweet= <?php echo $hashtagAll[$i]["tweet_id"] ?>&name_page=accueil" class="w-12 mt-1 group flex items-center text-gray-500 px-3 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                                        <svg class="text-center h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </a>
                                </div>

                                <div class="flex-1 text-center py-2 m-2">
                                    <a href="#" class="w-12 mt-1 group flex items-center text-gray-500 px-3 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                                        <svg class="text-center h-7 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    </a>
                                </div>

                                <div class="flex-1 text-center py-2 m-2">
                                    <a href="#" class="w-12 mt-1 group flex items-center text-gray-500 px-3 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                                        <svg class="text-center h-7 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </a>
                                </div>

                                <div class="flex-1 text-center py-2 m-2">
                                    <a href="#" class="w-12 mt-1 group flex items-center text-gray-500 px-3 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                                        <svg class="text-center h-7 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </a>
                                </div>
                                <div class="flex-1 text-center py-2 m-2">
                                <?php if($hashtagAll[$i]['id_user'] == $_SESSION['idUser'])
                                    {
                                        ?> 
                                        <label class="w-12 mt-1 group flex items-center text-gray-500 px-3 py-2 text-base leading-6 font-medium rounded-full hover:bg-blue-800 hover:text-blue-300">
                                            <svg class="svg-icon" style="width: 24px; height: 24px;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M850.517333 382.378667l-35.392 495.402666c-4.117333 57.6-53.333333 103.552-110.933333 103.552H319.786667c-57.706667 0-106.816-45.802667-110.933334-103.552L173.482667 382.378667A106.837333 106.837333 0 0 1 85.333333 277.333333v-42.666666a106.730667 106.730667 0 0 1 103.850667-106.624l138.005333-17.28A106.730667 106.730667 0 0 1 426.730667 42.666667h170.538666a106.858667 106.858667 0 0 1 99.52 68.117333l138.026667 17.258667A106.816 106.816 0 0 1 938.666667 234.666667v42.666666a106.730667 106.730667 0 0 1-88.149334 105.045334zM259.157333 384l34.837334 487.701333c0.938667 13.141333 12.906667 24.298667 25.813333 24.298667H704.213333c12.8 0 24.896-11.306667 25.813334-24.298667L764.842667 384H259.157333z m316.992 124.458667a42.666667 42.666667 0 1 1 85.034667 7.082666l-21.333333 256a42.666667 42.666667 0 1 1-85.034667-7.082666l21.333333-256z m-213.333333 7.082666a42.666667 42.666667 0 1 1 85.034667-7.082666l21.333333 256a42.666667 42.666667 0 1 1-85.034667 7.082666l-21.333333-256zM192.149333 213.333333C180.266667 213.333333 170.666667 222.912 170.666667 234.666667v42.666666c0 11.690667 9.642667 21.333333 21.482666 21.333334h639.701334C843.733333 298.666667 853.333333 289.088 853.333333 277.333333v-42.666666c0-11.690667-9.642667-21.333333-21.482666-21.333334a42.666667 42.666667 0 0 1-5.312-0.32l-170.496-21.333333A42.666667 42.666667 0 0 1 618.666667 149.333333c0-11.712-9.621333-21.333333-21.397334-21.333333h-170.538666A21.333333 21.333333 0 0 0 405.333333 149.333333a42.666667 42.666667 0 0 1-37.376 42.346667l-170.496 21.333333a42.666667 42.666667 0 0 1-5.312 0.32z"  /></svg>
                                            <button name="delete" class="btn btn-danger delete-tweet"></button>
                                        </label>
                                        <?php
                                    }  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-blue-800 border-4">
            </div>
            
		    <?php }$i++; }
		    }?>
        </div>
            <div class="w-2/5 h-12">
                <!--MENU DROIT-->
                <div class="relative text-gray-300 w-80 p-5 pb-0 mr-16">
                    <button type="submit" class="absolute ml-4 mt-3 mr-4">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                          <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                        </svg>
                      </button>

                    <input type="search" id="resultSearch" name="resultSearch" placeholder="Search Twitter" class="bg-blue-800 h-10 px-10 pr-5 w-full rounded-full text-sm focus:outline-none bg-purple-white shadow rounded border-0 resultSearch" >
				    <ul id="search-results"></ul>
                    
                </div>
                    <!--EN TT POUR VOUS-->
                <div class="max-w-sm rounded-lg bg-blue-800 overflow-hidden shadow-lg m-4 mr-20">
                    <div class="flex">
                        <div class="flex-1 m-2">
                            <h2 class="px-4 py-2 text-xl w-48 font-semibold text-white">Pour vous</h2>
                        </div>
                        <div class="flex-1 px-4 py-2 m-2">
                            <a href="" class=" text-2xl rounded-full text-white hover:bg-blue-800 hover:text-blue-300 float-right">
                                <svg class="m-2 h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </a>
                        </div>
                    </div>
                    <hr class="border-gray-600">
                        <!--PREMIERE TENDANCE-->
                    <?php $i = 0;
                    $count = count($hashtag);
                    while($i < $count)
                    { ?>
                        <div class="flex tendance"  data-tendance-id="<?php echo $hashtag[$i]['hashtag']; ?>">
                            <div class="flex-1">
                                <p class="px-4 ml-2 mt-3 w-48 text-xs text-gray-400" ><?php echo $i + 1?> . Tendance</p>
                                <h2 class="px-4 ml-2 w-48 font-bold text-white"><?php echo $hashtag[$i]["hashtag"]?></h2>
                                <p class="px-4 ml-2 mb-3 w-48 text-xs text-gray-400 occu"  data-occu-id="<?php echo $hashtag[$i]["occurences"]; ?>"><?php echo $hashtag[$i]["occurences"] ?> Tweets</p>
                            </div>
                            <div class="flex-1 px-4 py-2 m-2">
                                <a href="" class=" text-2xl rounded-full text-gray-400 hover:bg-blue-800 hover:text-blue-300 float-right">
                                    <svg class="m-2 h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                            </div>
                        </div>
                    <?php  $i++; } ?>
                    <hr class="border-gray-600">
                    <!--VOIR PLUS-->
                    <div class="flex">
                        <div class="flex-1 p-4">
                            <h2 class="px-4 ml-2 w-48 font-bold text-blue-400">Voir plus</h2>  
                        </div>
                    </div>
                </div>
                <!--SUGGESTION DE SUIVI-->
                <div class="max-w-sm rounded-lg bg-blue-800 overflow-hidden shadow-lg m-4 mr-20">
                    <div class="flex">
                        <div class="flex-1 m-2">
                            <h2 class="px-4 py-2 text-xl w-48 font-semibold text-white">Vous connaissez peut-être</h2>
                        </div>
                    </div>
                    <hr class="border-gray-600">
                        <!--PREMIERE SUGGESTION--> 
                        <?php 
                    if(isset($user))
                    {
                        $i = 0;
                        $count = count($user);
                        while($i < $count)
                        {
                            if(!in_array($user[$i]['username'],$tab)){
                        ?> 
                        <div class="flex flex-shrink-0 card-User" data-id-follow="<?php echo $user[$i][0];?>" data-id-home="<?php echo $_SESSION['idUser'] ?>" data-id-profile="<?php echo $id_user ?>">
                            <div class="flex-1 ">
                                <div class="flex items-center w-48">
                                    <div>
                                        <img class="inline-block h-10 w-auto rounded-full ml-4 mt-2" src="vue/img/<?php echo $user[$i]['avatar']?>" alt="" />
                                    </div>
                                    <div class="ml-3 mt-3">
                                        <p class="text-base leading-6 font-medium text-white">
                                        <?php echo $user[$i]['name'] ?>
                                        </p>
                                        <p class="text-sm leading-5 font-medium text-gray-400 group-hover:text-gray-300 transition ease-in-out duration-150">
                                        @<?php echo $user[$i]['username'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1 px-4 py-2 m-2">
                                    <button class="bg-transparent hover:bg-blue-500 text-white font-semibold hover:text-white py-2 px-4 border border-white hover:border-transparent rounded-full follow">
                                        Suivre
                                        </button>  
                            </div>
                        </div>
                        <hr class="border-gray-600">
                            <?php } 
                        $i++; 
                        }  
                    }?> 
                    <!--VOIR PLUS SUGGESTION SUIVI-->
                    <div class="flex">
                        <div class="flex-1 p-4">
                            <h2 class="px-4 ml-2 w-48 font-bold text-blue-400">Voir plus</h2>  
                        </div>
                    </div>
                </div>
            <div class="flow-root m-6 inline">
                <div class="flex-1">
                    <a href="#">
                        <p class="text-sm leading-6 font-medium text-gray-500">Terms Privacy Policy Cookies Imprint Ads info</p>
                    </a>
                </div>
                <div class="flex-2">
                    <p class="text-sm leading-6 font-medium text-gray-600"> © 2020 Twitter, Inc.</p>
                </div>
                </div>
        </div>
        <script src="https://unpkg.com/flowbite@1.5.2/dist/flowbite.js"></script>
    </body>
</html>