<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> -->

<script>
	function initialize() {
		var myLatlng = new google.maps.LatLng(42.121965,2.741803);
		var mapOptions = {
		zoom: 10,
		center: myLatlng
		};
						
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		var contentString = '<div id="content-map-pin">'+
							'<div id="siteNotice">'+
							'</div>'+
							'<div class="card-header">'+
							'<div class="house-class">Casa rural independiente</div>'+
							'<div class="house-TypeDot"></div>'+
							'<div class="card-title">Apartamentos rurales con barbacoa en Garrotxa</div>'+
							'</div>'+
							'<div class="card-img">'+
							'<div class="card-price">Desde<span class="card-price-hightlight">40,5€ </span>Persona / Noche</div>'+
							'<img src="assets/img/foto-casa.jpg" alt="foto-casa" width="739" height="397" />'+
							'</div>'+
							'<div class="card-items-core">'+
							'<span class="card-person">Personas <strong>1 - 8</strong></span>'+
							'<span class="card-rooms">Habitaciones <strong>4</strong></span>'+
							'<span class="card-baths">Baños <strong>3</strong></span>'+
							'</div>'+
							'<a href="#" class="card-btn">Ver Casa </a>'+
							'</div>';
						
		var infowindow = new google.maps.InfoWindow({
			content: contentString,
			maxWidth: 300
		});
						
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Apartamentos rurales con barbacoa en Garrotxa',
			icon: 'assets/img/icon-point-map.svg'
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	}
						
	google.maps.event.addDomListener(window, 'load', initialize);
						
</script>
sadfasdf
<div class="map-search-canvas" style="height:500px; width:800px; border:1px #333 solid;" id="map-canvas"></div>