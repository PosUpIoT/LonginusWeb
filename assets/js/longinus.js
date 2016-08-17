
$( document ).ready(function() {
  $.ajaxSetup({async:false});
  $('#adv-search').submit(function(e) {
	var self = this;
  	var term = $('#search').val();
  	var cat = $("#search-category option:selected" ).val();
  	var type = $("input[name=searchType]:checked").val();
	var token = $("#csrf_token")[0];
  	var properties = [];
	//estruturar os dados da request
  	var common_elements = $('.category-property input[type=text]');
  	$(common_elements).each(function( index ) {
	  properties.push({property: this.name, value:  this.value})
	});
  	var advanced_elements = $('.category-property.has-subproperties');
  	$(advanced_elements).each(function( index ) {
  		var prop = $(this).data('prop')
  		var prop_val = $('.category-property.has-subproperties input[name='+prop+']:checked').val();
  		if(prop_val != "")
  		{
  			var temp_data = [];
			var temp = null;
			$($("."+prop_val+"-sub .inner-props")).each(function( index ) {
				temp = $(this).select2('val');
				if(temp != null)
				{
					if(temp.length > 0)
					{
						temp_data.push({name: $(this).data('subprop'), value:temp});					
					}
				}
			});
	  		properties.push({property: prop, value:  prop_val, subproperties: temp_data})
  		}else{
  			properties.push({property: prop, value:  ''})
  		}
	});
  	//montar o payload da requisicao

  	$('#hdnProperties').val(JSON.stringify(properties));
	var posted_data = {'term': term, 'type': type, 'category': cat, 'properties': properties, 'location': {'rad': $('#hdnRadius').val(), 'lat': $('#hdnLat').val(), 'lon': $('#hdnLng').val()}};
	//Adicionando o token para verificacao CSRF
	posted_data[token.name] = token.value;
	$("#nloading-search").addClass( "hidden" );
	$("#loading-search").removeClass( "hidden" );
	  /**
  	$.ajax({
	  url: "/index.php/feed/search",
      type: 'POST',
      data: posted_data ,
		dataType:"json",
		ContentType : 'application/json',
      success:function(data) {
      	alert(data); 
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
	}).done(function() {
		$("#loading-search").addClass( "hidden" );
		$("#nloading-search").removeClass( "hidden" );
	});
	**/
  });

  $("#search-category").change(function() {
  		var str = "";
    	str = $("#search-category option:selected" ).val();
    	$.get("/index.php/feed/getCategoryProperties?category="+str, function(data, status){
        		$("#properties-container").html(data);
        		$('.inner-props').select2();
        		$('#input-plate').mask('SSS-0000');
				$('#input-height').mask('0.00');
				$('#input-age').mask('000');
     			$('.property-radio').change(function() {
	     				var current = this.value;
	     				$('.property-suboptions').addClass('hidden');
	     				$('.'+current+'-sub').removeClass('hidden'); 
        				$('.inner-props').select2().val(null).trigger('change');
	    		});
    	});
	});

	  $('#collapseExample').on('show.bs.collapse', function () {
	    mapSearch();
	  });
});

function mapSearch() {
	  var hdnRadius = document.getElementById('hdnRadius');
	  var hdnLat = document.getElementById('hdnLat');
	  var hdnLng = document.getElementById('hdnLng');

	  var map = new google.maps.Map(document.getElementById('map-search'), {
	    center: {lat: -34.397, lng: 150.644},
	    zoom: 9
	  });

	  var posCircle = new google.maps.Circle({
	    map: map,
	    draggable: true,
	    editable: true,
	    radius: 30000
	  });

	  posCircle.addListener('radius_changed', function() {
	    var pos = this.getCenter();
	    hdnRadius.value = this.getRadius();
	    hdnLat.value = pos.lat();
	    hdnLng.value = pos.lng();
	  });

	  posCircle.addListener('center_changed', function() {
	    var pos = this.getCenter();
	    hdnRadius.value = this.getRadius();
	    hdnLat.value = pos.lat();
	    hdnLng.value = pos.lng();
	  });

	  // Try HTML5 geolocation.
	  if (navigator.geolocation) {
	    navigator.geolocation.getCurrentPosition(function(position) {
	      var pos = {
	        lat: position.coords.latitude,
	        lng: position.coords.longitude
	      };
	      hdnRadius.value = posCircle.getRadius();
	      hdnLat.value = position.coords.latitude;
	   	  hdnLng.value = position.coords.longitude;
	      posCircle.setCenter(pos);
	      map.setCenter(pos);
	    }, function() {
	      //usar API como um fallback caso o browser barre
			$.post( "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyCBH3wfBW3jeBkTTDyU3uGPOXbWiwBbu1g",
					function(success) {

						var pos = {
							lat: success.location.lat,
							lng: success.location.lng
						};
						hdnRadius.value = posCircle.getRadius();
						hdnLat.value = success.location.lat;
						hdnLng.value  = success.location.lng;
						posCircle.setCenter(pos);
						map.setCenter(pos);
					})
					.fail(function(err) {
						console.log('Error: The Geolocation service failed.');
					});
	    });
	  } else {
	    // Browser doesn't support Geolocation
	      console.log('Error: Your browser doesn\'t support geolocation.');
	  }
	}


