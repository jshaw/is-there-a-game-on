<?
	require_once('_app/_classes/connect.php');
	require_once('_app/_classes/ScheduleClass.php');
	$schedule = new Schedule;

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<?	
	
		include_once('header.php');
		include_once('analytics.php');
		
	?>
	
</head>
<body>
	
	<div id="wrapper">
	
		<div id="header">
			<a href="index"><img src="_assets/_img/header.png" alt="Is There A Game On?" /></a>
		</div>
	
		<div id="content-schedule">
		
			<h3><img src="<? echo $schedule->getTeamLogo();?>" alt="<? echo $schedule->getTeamName(); ?>" /></h3>

			<div class="content-schedule">
				
				<div class="clear"></div>
						
				<div class="allTeamLogos b" id="allTeamLogos">
					<div id="sliderHolder" style="display:none; padding:10px;">
						<!-- will be a dynamically generated list of teams from the db based upon the league param in the url -->
						<? echo $schedule->getAllTeams($_GET['l']); ?>
					</div>
				</div>
	
				<a href="#allteams" class="viewAllTeams right b" id="viewAllTeams">VIEW ALL TEAMS</a>	
				
				<?
			
					echo $schedule->getAllGames();
			
				?>
				
			</div>
			<div class="clear"></div>
		
			<?
			
				require_once('footer.php');
			
			?>
	
		</div>	
	
	</div>
	
	<script type="text/javascript">
		$('#viewAllTeams').click(function(){
			$('#sliderHolder').slideToggle('slow');
			return false;
		});
	</script>
	
</body>
</html>