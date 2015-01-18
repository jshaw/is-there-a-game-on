/*

	HTML5 Library for Mobile Devices
	Version: 0.1
	By: Jordan Shaw
		http://jordanshaw.com
	

*/

// Siwtch it to init on page load

var mobileLocation = {
	
	init : function(lat,lng,key){
		
		//this = mobileLocation;
		
		console.log(key);
		
		this.key = key;
		mobileLocation.getUserLocation(lat,lng,this.key);
		
	},

	getUserLocation : function(lat,lng,key){
	
		console.log(lat);
		console.log(lng);
		console.log('HI');
		
		var geoCodeCallback = mobileLocation.locationCallback;
		
		var url = 'http://geocoder.ca/?latt=' + lat + '&longt=' + lng + '&corner=1&geoit=xml&range=&reverse=Reverse+GeoCode+it%21&jsonp=1&callback=mobileLocation.locationCallback';
		
		mobileLocation.ajaxCall(url, 'jsonp', true);
		
/*
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
*/
		
		
	},
	
	locationCallback : function(data){
	
		console.log(data);
		
		city = data.city;		
		var title = $('#header').html();
		title = title.substring(0, title.length-1);
		title = title + " in " + city + "?";
		console.log(title);
		
		var url = "http://isthereagameon.com/_dev/mobile/getGames.php?service=getLocalGameHeader&city=" + city + "&key=" + this.key + "&callback=mobileLocation.gamesToday";
		var key = "";
		var crossdomain = false;
		
		mobileLocation.getLocalGames(city);
		
		mobileLocation.ajaxCall(url, 'text', 'content', crossdomain);

	},
	
	
	getLocalGames : function(city){
		
		var url = "http://isthereagameon.com/_dev/mobile/getGames.php?service=getLocalGames&city=" + city + "&key=" + this.key + "&callback=mobileLocation.gamesToday";
		var key = "";
		var crossdomain = false;		
		
		mobileLocation.ajaxCall(url, 'text', 'localGames', crossdomain);
		
	},
	
	// run all ajax calls through here
	ajaxCall : function(url, type, element, crossdomain){
	
		$.ajax({
			url: url,
			dataType: type,
			jsonp: true,
			crossDomain: crossdomain,
			success: function(data){
				console.log(data);
				
				$('#'+element).prepend(data);
				
				// do nothing
				// since the callback is already doing it
			}
		});
	
	
	},
	
	gamesToday : function(data){
	
		console.log('data ln 92 ',data);
	
	}
	
	
}