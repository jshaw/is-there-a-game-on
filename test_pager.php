<!DOCTYPE html>

<!--

	test page to get pager working

 -->

<html lang="en">
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=620">
	<title>Is there a game on?</title>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css"/>
	<link rel="stylesheet" href="_assets/_css/style.css">
	<script src="_assets/_js/h5utils.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

	<?	
		include_once('analytics.php');
		require_once('_app/_classes/connect.php');
		require_once('_app/_classes/GamesClass.php');
		require_once('_app/_classes/PagerClass.php');
	?>

	<script type="text/javascript">
		$(function() {
			$( ".accordion" ).accordion({
				collapsible: true,
				autoHeight: false,
				navigation: false
			});
		});
		
		$(function() {
			$( ".otherGames" ).accordion({
				autoHeight: false,
				navigation: false,
				collapsible: true,
				active: false
			});
		});

		$(document).ready(function(){  
		    $(window).scroll(function () {  
		    	if($(document).scrollTop() > 325){
					var offset = $(document).scrollTop() + 200;
			        if(offset < $(document).height()){
			        	$('.globalPager').animate({top:offset+"px"},{duration:500,queue:false});
			        }
		        }else if ($(document).scrollTop() < 525){
		        	$('.globalPager').animate({top:525+"px"},{duration:500,queue:false});
		        }
		    });  
		});
		
	</script>
	
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<a href="index.php"><img src="_assets/_img/header.png" alt="Is There A Game On?" /></a>
		</div>
	
		<?
	
			$getGames = new games;
			$gamePager = new gamepager;
			$getGames->getLocalGameHeader();
	
		?>
	
		<div class="accordion" id="localGames">
		
			<?
				
				$getGames->getLocalGames();
				
			?>
			
		</div>
		
		<div class="pager" id="localPrevious"><a href="?d=<? $gamePager->previousDate(); ?>">Local Previous</a></div>
		<div class="pager" id="localNext"><a href="?d=<? $gamePager->nextDate(); ?>">Local Next</a></div>
				
		<?
		
			$getGames->getGlobalGameHeader();
		
		?>
		
		<div class="otherGames" id="globalGames">
		
			<?
			
				$getGames->getTodaysGames();
			
			?>
			
		</div>
		
		<div class="pager globalPager" id="globalPrevious"><a href="?d=<? $gamePager->previousDate(); ?>">Global Previous</a></div>
		<div class="pager globalPager" id="globalNext"><a href="?d=<? $gamePager->nextDate(); ?>">Global Next</a></div>
		
		<div class="clear"></div>
		
		<?
		
			require_once('footer.php');
		
		?>	
	
	</div>
	
</body>
</html>