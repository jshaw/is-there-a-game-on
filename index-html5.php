<!DOCTYPE html>
<html lang="en">

<!--

Original Mock up HTML5 Style

-->


<head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=620">
	<title>Is there a game on?</title>
	<link rel="stylesheet" href="_assets/_css/style.css">
	<script src="_assets/_js/h5utils.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<? include_once('analytics.php'); ?>
</head>
<body>
<section id="wrapper">
    <header>
      <h1 id="header">Is there a game on?</h1>
    </header>
<meta name="viewport" content="width=620" />

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<article>
		<p>Finding your location: <span id="status">checking...</span></p>
		<div id="gameToday"></div>
		<div id="nextHomeGame"></div>
	</article>
<script type="text/javascript">

var city= "";

function getLocation(url){

	$.ajax({
		url: url,
		dataType: 'jsonp',
		jsonp: true,
		crossDomain: true,
		success: function(data){
			// do nothing
			// since the callback is already doing it
		}
	});
	
}


function getGame(city){

	$.ajax({
		type: "GET",
		url: "_assets/_xml/nhl.xml",
		dataType: "xml",
		success: parseXml
	});
	
}

function parseXml(xml){

	var future = 0;
	var now = Date.today();

	//find every Tutorial and print the author
	$(xml).find("game").each(function(){
		
		if(Date.today().equals( Date.parse($(this).attr("date"))) == true){
			
			console.log('game today! ',$(this).attr("date"));
			var home = $(this).find("home").text();
			var visiting = $(this).find("visiting").text();
			var time = $(this).find("time").text();
			
			$("#gameToday").html(home + " VS " + visiting + " at " + time);
			
			return false;
		}
	});
	
	$(xml).find("game").each(function(){
		//Date.today().isBeforer(Date.parse($(this).attr("date")));
		
		var nextGameDate = Date.parse($(this).attr("date"));
		console.log(nextGameDate);
		var today = Date.today();
		console.log(today);
		if(today <= nextGameDate ){
		    console.log('YAY');
		    var home = $(this).find("home").text();
		    var visiting = $(this).find("visiting").text();
			var time = $(this).find("time").text();
			if(home == city || visiting == city){
				$("#nextHomeGame").html(home + " VS " + visiting.toString('MMMM dS, yyyy') + " on " + nextGameDate.toString('MMMM dS, yyyy') + " at " + time);
				return false;
			}
		}
		
		
/*
		var d = Date.parse($(this).attr("date"));
		if(Date.today().isAfter(d) == true ){
			
			var home = $(this).find("home").text();
			
			if(home == city){
				var visiting = $(this).find("visiting").text();
				var time = $(this).find("time").text();
				$("#nextHomeGame").html(home + " VS" + visiting + "at " + time);
				return false;
			}

		}
*/
		
		
		
		console.log($(this).attr("date"));
		
	
		//$("#output").append($(this).attr("author") + "<br />");
	});
	
}



function locationCallback(data){
	
	city = data.city;
	
	var title = $('#header').html();
	title = title.substring(0, title.length-1);
	title = title + " in " + city + "?";
	console.log(title);
	$('#header').html(title);
	
	getGame(city);
	
}


function success(position) {
  var s = document.querySelector('#status');
  
  if (s.className == 'success') {
    // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
    return;
  }
  
  s.innerHTML = "found you!";
  s.className = 'success';
  
  var mapcanvas = document.createElement('div');
  mapcanvas.id = 'mapcanvas';
  mapcanvas.style.height = '400px';
  mapcanvas.style.width = '560px';
    
  document.querySelector('article').appendChild(mapcanvas);
  
  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  var locationRequest = 'http://geocoder.ca/?latt=' + position.coords.latitude + '&longt=' + position.coords.longitude + '&corner=1&geoit=xml&range=&reverse=Reverse+GeoCode+it%21&jsonp=1&callback=locationCallback';
  
  getLocation(locationRequest);
  
  var myOptions = {
    zoom: 15,
    center: latlng,
    mapTypeControl: false,
    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
  
  var marker = new google.maps.Marker({
      position: latlng, 
      map: map, 
      title:"You are here!"
  });
}

function error(msg) {
  var s = document.querySelector('#status');
  s.innerHTML = typeof msg == 'string' ? msg : "failed";
  s.className = 'fail';
  
  // console.log(arguments);
}

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(success, error);
} else {
  error('not supported');
}

</script>
</section>
<script src="_assets/_js/prettify.packed.js"></script>
<script src="_assets/_js/date.js"></script>
</body>
</html>