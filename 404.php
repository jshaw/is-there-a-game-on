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
		
		<!-- Don't get confused between class and id 'content' -->
		<div id="content">
			
			<div class="pageCopy">
			
				<h1>404</h1>
					
				<h2>How did you get here?</h2>

				<p>This page is not built yet.</p>
				<p>You can see were working on it.</p>
				<p>This page could not exist too.</p>
				<p class="b">Anyways lets head back to the <a href="/index">home page!</a></p>
				
				<img src="_assets/_img/404.jpeg" alt="404 image" width="300" />
				
			</div>
			
			<?
			
				require_once('footer.php');
			
			?>	
		
		</div>
	
	</div>
	
</body>
</html>