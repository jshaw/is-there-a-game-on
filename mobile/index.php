<?
	require_once('../_app/_classes/connect.php');
	require_once('../_app/_classes/LocationClass.php');
	require_once('../_app/_classes/GamesClass.php');
	require_once('../_app/_classes/PagerClass.php');
	
/*
	$ul = new location;
	$city = $ul->getUserLocation();
*/
	// To get the user location with MOBILE we must their GPS HTML5 styles
	
	// Apparently not.
	// 74.198.9.134 is my MOBILE IP
	// http://whois.domaintools.com/74.198.9.134
	// https://ipdb.at/ip/74.198.9.134
	// http://www.ipaddresslocation.org/
	
	
	
/* 	$getGames = new games($city); */
	$gamePager = new gamepager;
	
	//http://stackoverflow.com/questions/1289061/best-way-to-use-php-to-encrypt-and-decrypt
	
	// we are declaring the special key here to prevent unwanted requests to our DB
	
	$key = date('now');
	$string = 'somepassword';
	$salt = 'somerandomshit';
	
	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	//$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=620">
	<title>Is There A Game On?</title>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css"/>
	<link rel="stylesheet" href="../_assets/_css/style.css">
	<script src="../_assets/_js/h5utils.js"></script>
<!-- This script is causinga redirect to http://isthereagameon.com/_dev/mobile/%5Bobject%20Object%5D 		 -->
<!-- 	<script src="../_assets/_js/location.js"></script> -->
	<script src="../_assets/_js/mobileLocation.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
	<script type="text/javascript">
			
		// if on a mobile device redirect to our mobile site
		// comment back in when ready
		if((navigator.userAgent.match(/iPhone/i))||
		(navigator.userAgent.match(/iPad/i))||
		(navigator.userAgent.match(/droid/i))||
		(navigator.userAgent.match(/kindle/i))||
		(navigator.userAgent.match(/mot/i))||
		(navigator.userAgent.match(/blackberry/i))||
		(navigator.userAgent.match(/iPod/i))){
			if (document.cookie.indexOf("iphone_redirect=false") == -1){
			
				// window.location = "http://mobile.isthereagameon.com";
				// or
				// window.location = "http://isthereagameon.com/mobile";
			
			}
		}
	</script>

	<?	
	
		include_once('../analytics.php');
		//echo $_SERVER['REMOTE_ADDR'];
		
	?>

	<script type="text/javascript">

/*
		$(document).ready(function(){  
		    $(window).scroll(function () {  
		    	if($(document).scrollTop() > 100){
					var offset = $(document).scrollTop() + 100;
			        if(offset < $(document).height()){
			        	$('.globalPager').animate({top:offset+"px"},{duration:500,queue:false});
			        }
		        }else if ($(document).scrollTop() < 100){
		        	$('.globalPager').animate({top:290+"px"},{duration:500,queue:false});
		        }
		    });  
		});
*/
		
	</script>
	
</head>
<body>
	
	<div id="wrapper">
	
		<div id="header">
			<a href="index.php"><img src="../_assets/_img/header.png" alt="Is There A Game On?" /></a>
		</div>
		
		<!-- Don't get confused between class and id 'content' -->
		<div id="content">
		
			<?
		
/* 				$getGames->getLocalGameHeader(true); */
		
			?>
		
			<div class="accordion" id="localGames">
			
				<?
					
/* 					$getGames->getLocalGames(true); */
					
				?>
				
			</div>
			
	<!-- 
	
			<div class="pager" id="localPrevious"><a href="?d=<? //$gamePager->previousDate(); ?>">Ç</a></div>
			<div class="pager" id="localNext"><a href="?d=<? //$gamePager->nextDate(); ?>">È</a></div>
	
	 -->
					
			<?
			
/* 				$getGames->getGlobalGameHeader(true); */
			
			?>
			
			<div class="otherGames" id="globalGames">
			
				<?
				
/* 					$getGames->getTodaysGames(true); */
				
				?>
				
			</div>
			
			<div class="clear"></div>
			
			<?
			
				require_once('../footer.php');
			
			?>	
		
		</div>
		
		<div class="pager globalPager" id="globalPrevious"><a href="?d=<? $gamePager->previousDate(); ?>"><img src="../_assets/_img/prev.png" alt="prev" /></a></div>
		<div class="pager globalPager" id="globalNext"><a href="?d=<? $gamePager->nextDate(); ?>"><img src="../_assets/_img/next.png" alt="next" /></a></div>
	
	</div>
	
	<script type="text/javascript">
	
		function success(position) {
		
			console.log(position);
		
			//var s = document.querySelector('#status');
			
/*
			if (s.className == 'success') {
				// not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
				return;
			}
*/
			
			var lat = position.coords.latitude;
			var lng = position.coords.longitude;
			
			mobileLocation.init(lat,lng, "<? echo $encrypted; ?>");
			
/*
			s.innerHTML = "found you!";
			s.className = 'success';
*/
			
		}
		
		function error(msg) {
			var s = document.querySelector('#status');
			s.innerHTML = typeof msg == 'string' ? msg : "failed";
			s.className = 'fail';
			
			// console.log(arguments);
		}
		
		$(document).ready(function(){
		
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(success, error);
			} else {
				error('not supported');	
			}
		
		});
		
		/*
			These will be used once the page is fully loaded
			Once generatged via JS with the service call
		*/
/*
		$(function() {
			$( ".accordion" ).accordion({
				collapsible: true,
				autoHeight: false,
				navigation: false,
				event: "click"
			});
		});
		
		$(function() {
			$( ".otherGames" ).accordion({
				autoHeight: false,
				navigation: false,
				collapsible: true,
				active: false,
				event: "click"
				
			});
		});
		
*/
		
	</script>
	
</body>
</html>