<?
	require_once('_app/_classes/connect.php');
	require_once('_app/_classes/LocationClass.php');
	require_once('_app/_classes/GamesClass.php');
	require_once('_app/_classes/PagerClass.php');
	
	$ul = new location;
	$city = $ul->getUserLocation();
	
	$getGames = new games($city);
	$gamePager = new gamepager;

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<?
	
		include_once('header.php');
		include_once('analytics.php');
		
	?>

	<script type="text/javascript">
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
		
	</script>
	
</head>
<body>
	
	<div id="wrapper">
	
		<div id="header">
			<a href="index"><img src="_assets/_img/header.png" alt="Is There A Game On?" /></a>
		</div>
		
		<!-- Don't get confused between class and id 'content' -->
		<div id="content">
		
			<?
		
				$getGames->getLocalGameHeader(false);
		
			?>
		
			<div class="accordion" id="localGames">
			
				<?
					
					$getGames->getLocalGames(false);
					
				?>
				
			</div>			
					
			<?
			
				$getGames->getGlobalGameHeader(false);
			
			?>
			
			<div class="otherGames" id="globalGames">
			
				<?
				
					$getGames->getTodaysGames(false);
				
				?>
				
			</div>
			
			<div class="clear"></div>
			
			<?
			
				require_once('footer.php');
			
			?>	
		
		</div>
		
		<div class="pager globalPager" id="globalPrevious"><a href="index/<? $gamePager->previousDate(); ?>"><img src="_assets/_img/prev.png" alt="prev" /></a></div>
		<div class="pager globalPager" id="globalNext"><a href="index/<? $gamePager->nextDate(); ?>"><img src="_assets/_img/next.png" alt="next" /></a></div>
	
	</div>
	
</body>
</html>