$(document).ready(function(){
	$(".miniaturas a").click(function(){
		var slide = $(this).attr("data-slide-to");
		$(".carousel-indicators li[data-slide-to='"+slide+"']").click();
		return false;
	})

	var latitude = parseFloat($("#latitude").val());
	var longitude = parseFloat($("#longitude").val());

	var myOptions = {
         zoom: 16,
         center: new google.maps.LatLng(latitude, longitude),
         mapTypeId: google.maps.MapTypeId.ROADMAP
      };

    var map = new google.maps.Map(document.getElementById("map"), myOptions);

    var myLatLng = {lat: latitude, lng: longitude};

    var marker = new google.maps.Marker({
	    position: myLatLng,
	    map: map
  	});

});