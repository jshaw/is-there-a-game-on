<!-- Schedule Slider -->

<?
	require_once('_app/_classes/connect.php');
	require_once('_app/_classes/ScheduleClass.php');
	$schedule = new Schedule;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=620">
	<title>Is There A Game On?</title>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css"/>
	<link rel="stylesheet" href="_assets/_css/style.css">
	<script src="_assets/_js/h5utils.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

	<?	
	
		include_once('analytics.php');
		
	?>

	<script type="text/javascript">
		$(function() {
			$( ".accordion" ).accordion({
				collapsible: true,
				autoHeight: false,
				navigation: false
			});
		});
	</script>
	
	
	
	<style type="text/css">
		
		#allTeamLogos{
			position:relative;
		}
	
	</style>
	
</head>
<body>
	

	<div id="wrapper">
	
		<div id="header">
			<a href="index.php"><img src="_assets/_img/header.png" alt="Is There A Game On?" /></a>
		</div>
	
		<div id="content">
		
           <div class="content-schedule">
			<h1 class="schedule">All ongoing and future games for:<br /><? echo $schedule->getTeamName();?></h1>
			<p id="viewAllTeams">See All Teams</p>
			<div class="allTeamLogos b" id="allTeamLogos">
				<!-- will be a dynamically generated list of teams from the db based upon the league param in the url -->
				<div id="sliderHolder" style="display:none;">
					<? echo $schedule->getAllTeams($_GET['l']); ?>
				</div>
			</div>
			
			</div>
		<div class="clear"></div>
		
		<?
		
			require_once('footer.php');
		
		?>	
	
	</div>
	
	
	<script type="text/javascript">
		
		$('#viewAllTeams').click(function(){
			$('#sliderHolder').slideToggle('slow');
		});
		
	</script>
	
</body>
</html>