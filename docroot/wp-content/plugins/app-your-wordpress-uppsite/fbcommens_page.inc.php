<?php


function mysiteapp_facebook_comments_page(){

$encoded_url = urlencode($_GET['url'].'&screen='.$_GET['screen'].'&app='.$_GET['app'].'&msa_facebook_comment_page=1');
$self_url = urlencode(get_bloginfo('wpurl'));

$screen_width = '320';

if(isset($_GET['screen'])){

  $screen_width = $_GET['screen'];
}

return "<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:fb=\"http://www.facebook.com/2008/fbml\">

<head>

<meta name=\"viewport\" content=\"width={$screen_width},user-scalable=false\" />
<meta name=\"viewport\" content=\"initial-scale=1.0\" />

</head>

<div id=\"fb-root\"></div>
<script>

window.fbAsyncInit = function() {
 FB.init({appId: '{$_GET['app']}', status: true, cookie: true, xfbml: true});
 
     /* All the events registered */
     FB.Event.subscribe('auth.login', function(response) {
         // do something with response
    
         login();
     });
     FB.Event.subscribe('auth.logout', function(response) {
         // do something with response

	}); 
     FB.getLoginStatus(function(response) {
                    if (response.session) {
                        login();
                    }
                    else{
                    
                    FB.api('/me', function(response) {
			window.location = 'http://www.facebook.com/dialog/oauth/?scope=publish_stream&client_id={$_GET['app']}&redirect_uri={$self_url}?url={$encoded_url}&response_type=token';
			
   					 });
							
             }
        });     
 };


  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = \"//connect.facebook.net/en_US/all.js\";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
</script>

<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = \"//connect.facebook.net/en_US/all.js#xfbml=1\";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>

<div class=\"fb-comments\" data-href=\"{$_GET['url']}\" data-num-posts=\"0\" data-width=\"{$screen_width}\" ></div>


</html>";
}